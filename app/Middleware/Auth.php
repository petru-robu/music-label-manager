<?php

class Auth
{
    public function handle()
    {
        if(!isset($_SESSION['user_id']))
        {
            header('Location: /login'); // redirect to login
            exit;
        }
    }
}