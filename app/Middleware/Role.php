<?php


class Role
{
    public function handle($requiredRole)
    {
        $userRole = $_SESSION['role'] ?? null;
        $userRole = "{$userRole}";

        if($userRole !== $requiredRole)
        {
            http_response_code(403);
            echo "Access denied! You don't have the role for this!";
            exit;
        }
    }
}