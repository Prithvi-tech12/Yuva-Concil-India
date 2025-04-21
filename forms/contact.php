<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Replace contact@example.com with your real receiving email address
  $receiving_email_address = 'contact@example.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $errors = [];

  if (empty($_POST['name']) || strlen(trim($_POST['name'])) < 2) {
    $errors[] = "Please enter a valid name.";
  }

  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  }

  if (empty($_POST['subject']) || strlen(trim($_POST['subject'])) < 3) {
    $errors[] = "Please enter a subject with at least 3 characters.";
  }

  if (empty($_POST['message']) || strlen(trim($_POST['message'])) < 10) {
    $errors[] = "Please enter a message with at least 10 characters.";
  }

  if (!empty($errors)) {
    // Return error messages as JSON (good for AJAX)
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
  }
  
  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  */

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['message'], 'Message', 10);

  echo $contact->send();
?>
