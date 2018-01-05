<?php

namespace DNADesign\AlertManager\Tasks;

use DNADesign\AlertManager\Models\EmailIssue;
use SilverStripe\Dev\BuildTask;

class EmailIssuePurge extends BuildTask {

	public function run($request) {
		$olds = EmailIssue::get();
		foreach($olds as $old) {
			$old->delete();
		}
	}

}