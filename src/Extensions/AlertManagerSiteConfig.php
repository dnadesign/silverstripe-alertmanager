<?php

namespace DNADesign\AlertManager\Extensions;

use SilverStripe\ORM\DataExtension;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

/**
 * Adds new global settings.
 */

class AlertManagerSiteConfig extends DataExtension
{

    private static $db = array(
        'EmailFrom' => 'Varchar',
    );

    public function updateCMSFields(FieldList $fields)
    {
        // emails
        $fields->addFieldToTab('Root.Emails', new TextField('EmailFrom', 'All emails come from this address:'));
    }
}
