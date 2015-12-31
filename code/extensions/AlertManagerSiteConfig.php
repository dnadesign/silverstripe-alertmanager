<?php
/**
 * Adds new global settings.
 */

class AlertManagerSiteConfig extends DataExtension
{

    public static $db = array(
        'EmailFrom' => 'Varchar',
    );

    public function updateCMSFields(FieldList $fields)
    {
        // emails
        $fields->addFieldToTab('Root.Emails', new TextField('EmailFrom', 'All emails come from this address:'));
    }
}
