<?php
if (class_exists('StyledHtmlEmail')) {
	$mailer = new PHPMailerMailer();
	Email::set_mailer($mailer);
}