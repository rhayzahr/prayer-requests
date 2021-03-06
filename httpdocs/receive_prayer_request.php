<?php
/*
access database with server information
Receive information from Prayer Request form
Put Prayer request information in database
Create a unique hash for each prayer and place in database
Send confirmation email
! - Display confirmation message on page (change once on main site)
*/

		require_once 'access_database.php';
		require_once 'message_creator.php';
		require_once 'clean_io.php';
		require 'emailer.php';

		//db info pulled from access_database.php
		$mysqli = new MySQLi($db_server, $db_user, $db_pass, $db_name) or die(mysqli_error());

		// The request was received from either front-end website httpdocs/index.html(value==False) or back-end admin site httpdocs/admin/index.php(value==True)
		$is_admin = $_POST['is-admin'];

		// Receive info from prayer request form
		$user_first_name = (isset($_POST['anonymous'])) ? '' : sanitize($_POST['user-first']);
		$user_first_name = str_replace(' ', '', $user_first_name);
		$user_last_name = (isset($_POST['anonymous'])) ? '' : sanitize($_POST['user-last']);
		$email_to = (isset($_POST['anonymous'])) ? '' : sanitize($_POST['email']);
		if($is_admin == "True")
				$phone = (isset($_POST['anonymous'])) ? '' : sanitize($_POST['phone']);
		else $phone = '';
		$contact_requested = ($email_to == '') ? 0 : 1;
		$follow_up_needed = $contact_requested;
		$email_sent = 0;
		$user_responded = 0;
		$prayer_answered = 0;
		$attend = (isset($_POST['attend'])) ? 1 : 0;
		$intercession = (isset($_POST['intercession'])) ? 1 : 0;
		$prayer_is_for = ($intercession) ? sanitize($_POST['prayer-is-for']) : $user_first_name;
		$prayer_is_for = rtrim($prayer_is_for);
		$prayer_category = sanitize($_POST['category']);
		$request = sanitize($_POST['prayer-request']);
		$time = date("Y:m:d H:i:s");

		//pass database info and prayer request field info to create a prayer
		setNewPrayerInDatabase($mysqli, $user_first_name, $user_last_name, $attend, $intercession, $prayer_is_for,
					$contact_requested, $phone, $email_to, $prayer_category, $request, $time, $follow_up_needed, $email_sent,
					$user_responded, $prayer_answered);

		//Found in access_database.php
		setPrayerHash($mysqli, $time);

		if ($email_to) {
			sendConfirmationEmail($smtp_user, $smtp_pass, $user_first_name, $email_to, $attend, $intercession);
		}
		

		//echo getConfirmationMessage($user_first_name, $attend, $intercession);

		header("location: https://rock.church");  exit;

?>
