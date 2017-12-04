<?php

namespace DNADesign\AlertManager\Models;

use SilverStripe\ORM\DataObject;

class EmailIssue extends DataObject
{

    private static $db = array(
        'EmailAddress' => 'Varchar',
        'Content' => 'Text',
    );

    private static $table_name = 'EmailIssue';

    private static $summary_fields = array(
        'EmailAddress',
        'Content'
    );
}
