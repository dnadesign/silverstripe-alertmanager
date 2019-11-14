<?php

namespace DNADesign\AlertManager\Helpers;

use Exception;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\Security\Member;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Email\Email;
use SilverStripe\SiteConfig\SiteConfig;
use DNADesign\AlertManager\Models\UserAlert;
use DNADesign\AlertManager\Models\EmailIssue;

class AlertManager
{
    public static function addInterfaceAlert($content, $type = 'good')
    {
        $alert = array('Content' => $content, 'Type' => $type);
        $sesh = Controller::curr()->getRequest()->getSession();
        $currentAlerts = $sesh->get('InterfaceAlerts');
        if (!$currentAlerts) {
            $currentAlerts = array();
        }
        $currentAlerts[] = $alert;
        $sesh->set('InterfaceAlerts', $currentAlerts);
    }

    public static function GetInterfaceAlerts()
    {
        $al = new ArrayList();
        $sesh = Controller::curr()->getRequest()->getSession();
        $currentAlerts = $sesh->get('InterfaceAlerts');
        if (is_array($currentAlerts) && count($currentAlerts) > 0) {
            foreach ($currentAlerts as $alert) {
                $al->push(new ArrayData($alert));
            }
        }
        $sesh->set('InterfaceAlerts', null);

        return $al;
    }

    public static function addUserAlert(Member $member, $type, $content)
    {
        $alert = new UserAlert();
        $alert->MemberID = $member->ID;
        $alert->Type = $type;
        $alert->Content = $content;
        $alert->write();

        return $alert;
    }

    public static function GetUserAlerts()
    {
        $member = Member::currentUser();
        if ($member) {
            $obs = UserAlert::get()->filter(array('MemberID', $member->ID));
            if ($obs) {
                foreach ($obs as $ob) {
                    $ob->delete();
                }

                return $obs;
            }
        }

        return false;
    }

    public static function SendEmail($to, $subject, $template, $templateData = null)
    {
        $emailFrom = Email::config()->get('admin_email');

        $config = SiteConfig::current_site_config();
        if ($config->EmailFrom) {
            $emailFrom = $config->EmailFrom;
        }

        // create email
        $email = new Email($emailFrom, $to, $subject);
        $email->setData(array());

        $email->addData('SiteConfig', $config);

        //set template
        $email->setHTMLTemplate($template);
        // populate
        if (is_a($templateData, DataObject::class)) {
            $email->addData('DataObject', $templateData);
        } else {
            $email->addData('Data', $templateData);
        }

        $email->addData('Subject', $subject);
        //send mail
        try {
            $email->send();
        } catch (Exception $e) {
            $ei = new EmailIssue();
            $ei->EmailAddress = $to;
            $ei->Content = $e->getMessage();
            $ei->write();
        }
    }
}
