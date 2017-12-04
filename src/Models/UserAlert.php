<?php

namespace DNADesign\AlertManager\Models;

use SilverStripe\ORM\DataObject;

class UserAlert extends DataObject
{

    private static $db = array(
        'Content' => 'HTMLText',
        'Type' =>    'Enum("Red,Green,Orange")'
    );

    private static $has_one = array(
        'Member' => 'Member'
    );

    private static $table_name = 'UserAlert';

    private static $default_sort = 'Type';
}
