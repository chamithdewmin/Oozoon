<?php
class PHP_Email_Form {
  public $to = '';
  public $from_name = '';
  public $from_email = '';
  public $subject = '';
  public $ajax = false;
  public $smtp = false;
  public $messages = array();

  public function add_message($content, $label = '', $length = 0) {
    if (!empty($content)) {
      $this->messages[] = ($label ? "<strong>$label:</strong> " : '') . nl2br(stripslashes($content));
    }
  }

  public function send() {
    $message_body = implode("<br><br>", $this->messages);

    if ($this->smtp) {
      return $this->send_smtp($message_body);
    } else {
      $headers = "From: ".$this->from_name." <".$this->from_email.">\r\n";
      $headers .= "Reply-To: ".$this->from_email."\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
      return mail($this->to, $this->subject, $message_body, $headers);
    }
  }

  private function send_smtp($body) {
    if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
      require 'PHPMailer/PHPMailer.php';
      require 'PHPMailer/SMTP.php';
      require 'PHPMailer/Exception.php';
    }

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = $this->smtp['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $this->smtp['username'];
    $mail->Password = $this->smtp['password'];
    $mail->Port = $this->smtp['port'];
    $mail->SMTPSecure = $this->smtp['encryption'] ?? 'tls';

    $mail->setFrom($this->from_email, $this->from_name);
    $mail->addAddress($this->to);
    $mail->addReplyTo($this->from_email, $this->from_name);
    $mail->isHTML(true);
    $mail->Subject = $this->subject;
    $mail->Body = $body;

    return $mail->send();
  }
}



// Gmail SMTP configuration
$contact->smtp = array(
  'host' => 'smtp.gmail.com',
  'username' => 'chamithsamarakon@gmail.com',       // ← Your Gmail
  'password' => 'ibpzqbzfjkvpsnqj',         // ← 16-char Gmail App Password
  'port' => '587',
  'encryption' => 'tls'
);