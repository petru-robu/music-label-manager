<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Services/MailService.php';

class ContactController extends Controller
{
    public function index()
    {
        // returns a view of the contact form
        $this->render('Contact/index');
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            http_response_code(405);
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '')
        {
            $_SESSION['error'] = 'All fields are required.';
            header('Location: /contact');
            exit;
        }

        // CAPTCHA check
        $captcha = $_POST['captcha'] ?? '';
        if (empty($captcha) || $captcha !== ($_SESSION['captcha'] ?? ''))
        {
            $_SESSION['error'] = 'Invalid captcha!';
            header('Location: /contact');
            exit;
        }

        try
        {
            $mailService = new MailService();
            $mailService->sendContactMessage($name, $email, $message);
            $_SESSION['success'] = 'Message sent successfully.';
        }
        catch (Exception $e)
        {
            $_SESSION['error'] = 'Failed to send message.';
        }

        header('Location: /contact');
        exit;
    }


}
