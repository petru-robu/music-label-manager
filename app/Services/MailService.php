<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;

class MailService
{
    private PHPMailer $mail;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->safeLoad();

        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['SMTP_USER'];
        $this->mail->Password = $_ENV['SMTP_PASS'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;    

        // var_dump($this->mail->Username);
        // var_dump($this->mail->Password);

        $this->mail->setFrom($_ENV['SMTP_USER'], 'App Name');
        $this->mail->isHTML(true);
    }

    public function send(string $to, string $subject, string $body): bool
    {
        $this->mail->clearAddresses();
        $this->mail->addAddress($to);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;

        return $this->mail->send();
    }

    public function sendContactMessage(
        string $name,
        string $email,
        string $message
    ): bool {
        $body = "
            <h3>New Contact Message</h3>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
        ";

        return $this->send(
            $_ENV['CONTACT_RECEIVER_EMAIL'],
            'Contact Form Submission',
            $body
        );
    }
}
