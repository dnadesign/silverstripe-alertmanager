<?php
class EmailIssue extends DataObject {

	private static $db = array(
		'EmailAddress' => 'Varchar',
		'Content' => 'Text',
	);

	private static $summary_fields = array(
		'EmailAddress',
		'Content'
	);
}