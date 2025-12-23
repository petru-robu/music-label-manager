<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Services/MailService.php';

class ContactController extends Controller
{
    // HELPERS
    private function setError(string $message): void
    {
        $_SESSION['error'] = $message;
    }

    private function setSuccess(string $message): void
    {
        $_SESSION['success'] = $message;
    }

    private function getError(): ?string
    {
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        return $error;
    }

    private function getSuccess(): ?string
    {
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        return $success;
    }

    private function renderWithFlash(string $view, array $extra = [])
    {
        return $this->render($view, array_merge($extra, [
            'error' => $this->getError(),
            'success' => $this->getSuccess(),
        ]));
    }

    private function validateCaptcha(string $input): bool
    {
        return !empty($input) && $input === ($_SESSION['captcha'] ?? '');
    }

    // CONTROLLER ACTIONS
    public function index()
    {
        $this->renderWithFlash('Contact/index');
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            exit;

        // Debug once if needed
        error_log(print_r($_POST, true));

        $name = isset($_POST['name']) ? trim((string)$_POST['name']) : '';
        $email = isset($_POST['email']) ? trim((string)$_POST['email']) : '';
        $message = isset($_POST['message']) ? trim((string)$_POST['message']) : '';

        if ($name === '' || $email === '' || $message === '')
        {
            $this->setError('All fields are required.');
            header('Location: /contact');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->setError('Invalid email address.');
            header('Location: /contact');
            exit;
        }

        if (!$this->validateCaptcha($_POST['captcha'] ?? ''))
        {
            $this->setError('Invalid captcha!');
            header('Location: /contact');
            exit;
        }

        try
        {
            $mailService = new MailService();
            $mailService->sendContactMessage($name, $email, $message);
            $this->setSuccess('Message sent successfully.');
        }
        catch (Exception $e)
        {
            $this->setError('Failed to send message.');
        }

        header('Location: /contact');
        exit;
    }



}
