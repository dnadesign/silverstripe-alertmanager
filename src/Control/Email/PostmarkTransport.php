<?php

namespace DNADesign\AlertManager;

use Postmark\Transport;
use SilverStripe\Core\Config\Config;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Config\Configurable;
use Swift_Mime_Message;

/**
 * Wraps WildBit\Postmark\Transport so that the server_token gets via
 * SilverStripe's config system
 */

class PostmarkTransport extends Transport
{
    use Configurable;

    public function __construct()
    {
        parent::__construct($this->config()->server_token);
    }

    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);
        return parent::send($message, $failedRecipients);
    }

    /**
     * Before sending a message make sure all our overrides are taken into account
     *
     * @param \Swift_Events_SendEvent $evt
     */
    protected function beforeSendPerformed(Swift_Mime_Message $message)
    {

        $sendAllTo = Email::getSendAllEmailsTo();
        if (!empty($sendAllTo)) {
            $this->setTo($message, $sendAllTo);
        }

        $ccAllTo = Email::getCCAllEmailsTo();
        if (!empty($ccAllTo)) {
            foreach ($ccAllTo as $address => $name) {
                $message->addCc($address, $name);
            }
        }

        $bccAllTo = Email::getBCCAllEmailsTo();
        if (!empty($bccAllTo)) {
            foreach ($bccAllTo as $address => $name) {
                $message->addBcc($address, $name);
            }
        }

        $sendAllFrom = Email::getSendAllEmailsFrom();
        if (!empty($sendAllFrom)) {
            $this->setFrom($message, $sendAllFrom);
        }
    }


    /**
     * @param \Swift_Mime_Message $message
     * @param array|string $to
     */
    protected function setTo($message, $to)
    {
        $headers = $message->getHeaders();
        $origTo = $message->getTo();
        $cc = $message->getCc();
        $bcc = $message->getBcc();

        // set default recipient and remove all other recipients
        $message->setTo($to);
        $headers->removeAll('Cc');
        $headers->removeAll('Bcc');

        // store the old data as X-Original-* Headers for debugging
        $headers->addMailboxHeader('X-Original-To', $origTo);
        $headers->addMailboxHeader('X-Original-Cc', $cc);
        $headers->addMailboxHeader('X-Original-Bcc', $bcc);
    }

    /**
     * @param \Swift_Mime_Message $message
     * @param array|string $from
     */
    protected function setFrom($message, $from)
    {
        $headers = $message->getHeaders();
        $origFrom = $message->getFrom();
        $headers->addMailboxHeader('X-Original-From', $origFrom);
        $message->setFrom($from);
    }
}