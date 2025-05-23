<?php
// Display errors for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Your real receiving email address
$receiving_email_address = 'hello@oozoondc.com';

// Load the PHP Email Form library
if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
  include($php_email_form);
} else {
  die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'] ?? '';
$contact->from_email = $_POST['email'] ?? '';
$contact->subject = $_POST['subject'] ?? 'New Contact Form Submission';

// Add messages
$contact->add_message($_POST['name'], 'Name');
$contact->add_message($_POST['email'], 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

// Optional SMTP (recommended for live)
$contact->smtp = array(
  'host' => 'smtp.yourprovider.com',
  'username' => 'your_smtp_username',
  'password' => 'your_smtp_password',
  'port' => '587'
);

// Send email
echo $contact->send();
?>
