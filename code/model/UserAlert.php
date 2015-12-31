<?php
class UserAlert extends DataObject
{

    private static $db = array(
        'Content' => 'HTMLText',
        'Type' =>    'Enum("Red,Green,Orange")'
    );

    private static $has_one = array(
        'Member' => 'Member'
    );

    private static $default_sort = 'Type';
}
