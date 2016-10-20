<?php

require 'vendor/autoload.php';
use Mailgun\Mailgun;

// Replace this with your own email address
$siteOwnersEmail = 'emjovi@gmail.com';

if ($_POST) {

	$mailer = new Mailgun(getenv('MAILGUN_KEY'));
	$domain = "sandbox6b83885842b74272972f9778159da9ee.mailgun.org";

	$name = trim(stripslashes($_POST['contactName']));
	$email = trim(stripslashes($_POST['contactEmail']));
	$subject = trim(stripslashes($_POST['contactSubject']));
	$contact_message = trim(stripslashes($_POST['contactMessage']));
	$error = array();

	// Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Please enter your name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Please enter a valid email address.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Your message should have at least 15 characters.";
	}
	// Subject
	if ($subject == '') {
		$subject = "Contact Form Submission";
	}


	// Set Message
	$message = "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
	$message .= "Message: <br />";
	$message .= $contact_message;
	$message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

	// Set From: header
	$from =  $name . " <" . $email . ">";

	// Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


	if ( empty($error) ) {

		try {
			//ini_set("sendmail_from", $siteOwnersEmail); // for windows server
			//$mail = mail($siteOwnersEmail, $subject, $message, $headers);
			$send = $mailer->sendMessage($domain, array(
				'from' => $email,
	            'to' => $siteOwnersEmail,
				'subject' => $subject,
				'text' => $message
			));

			if ($send) {
				$error['OK'] = "done";
				echo json_encode($error);
			} else {
				$error['sending'] = "Something went wrong. Please try again.";
				echo json_encode($error);
			}
		} catch (Exception $e) {
			$error['sending'] = "Something went wrong. Please try again.";
			echo json_encode($error);
		}

	} # end if - no validation error

	else {

		echo json_encode($error);

	} # end else - there was a validation error

}
