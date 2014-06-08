<?php
class AlertManager {

	public static function addInterfaceAlert($content, $type = 'good') {
		$alert = array('Content' => $content, 'Type' => $type);
		$currentAlerts = Session::get('InterfaceAlerts');
		if (!$currentAlerts) {
			$currentAlerts = array();
		}
		$currentAlerts[] = $alert;
		Session::set('InterfaceAlerts', $currentAlerts);
	}

	public static function GetInterfaceAlerts() {
		$al = new ArrayList();
		$currentAlerts = Session::get('InterfaceAlerts');
		if (is_array($currentAlerts) && count($currentAlerts) > 0) {
			foreach ($currentAlerts as $alert) {
				$al->push(new ArrayData($alert));
			}
		}
		Session::set('InterfaceAlerts', null);
		return $al;
	}

	public static function addUserAlert(Member $member, $type, $content) {
		$alert = new UserAlert();
		$alert->MemberID = $member->ID;
		$alert->Type = $type;
		$alert->Content = $content;
		$alert->write();
		return $alert;
	}

	public static function GetUserAlerts() {
		$member = Member::currentUser();
		if ($member) {
			$obs = DataObject::get('UserAlert')->filter(array('MemberID', $member->ID));
			if ($obs) {
				foreach ($obs as $ob) {
					$ob->delete();
				}
				return $obs;
			}
		}
		return false;
	}

	public static function SendEmail($to, $subject, $template, $templateData = null) {
		// create email
		$config = SiteConfig::current_site_config();
		if ($config->EmailFrom) {
			$emailFrom = $config->EmailFrom;
		} else {
			$emailFrom = Email::getAdminEmail();
		}

		if (class_exists('StyledHtmlEmail')) {
			$email = new StyledHtmlEmail($emailFrom, $to, $subject);
		} else {
			$email = new Email($emailFrom, $to, $subject);
		}
		//set template
		$email->setTemplate($template);
		// populate
		if (!$templateData) {
			$templateData = array();
		} else if (is_a($templateData, 'DataObject')) {
			$ob = $templateData;
			$templateData = array();
			$templateData[get_class($ob)] = $ob;
		}
		$templateData['SiteConfig'] = $config;
		$templateData['SiteAddress'] = Director::absoluteBaseURL();
		$email->populateTemplate($templateData);
		//send mail
		try {
			$email->send();
		} catch(Exception $e) {
			$ei = new EmailIssue();
			$ei->EmailAddress = $to;
			$ei->Content = $e->getMessage();
			$ei->write();
		}
	}

}