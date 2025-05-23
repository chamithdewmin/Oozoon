<?php
// Enable PHP error reporting for debugging (turn off in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Allow CORS for JS fetch requests (optional for local development)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Include the main email form class
require_once('../assets/vendor/php-email-form/php-email-form.php');

// Set your destination email address (where the contact form should send to)
$receiving_email_address = 'hello@oozoondc.com';

// Initialize the form handler
$contact = new PHP_Email_Form;
$contact->ajax = true;
$contact->to = $receiving_email_address;

// Collect data from the form
$contact->from_name = $_POST['name'] ?? '';
$contact->from_email = $_POST['email'] ?? '';
$contact->subject = $_POST['subject'] ?? 'New Contact Form Submission';

// Add form content to the message
$contact->add_message($_POST['name'], 'Name');
$contact->add_message($_POST['email'], 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

// Configure SMTP for Gmail (App Password required)
$contact->smtp = array(
  'host' => 'smtp.gmail.com',
  'username' => 'chamithsamarakon@gmail.com',
  'password' => 'ibpzqbzfjkvpsnqj', // 16-digit App Password from https://myaccount.google.com/apppasswords
  'port' => '587',
  'encryption' => 'tls'
);

// Send the email and echo the result
echo $contact->send() ? 'OK' : 'Message failed';
