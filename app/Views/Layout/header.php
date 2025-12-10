<?php
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Music Label App') ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<nav class="navbar">
    <a href="/">Home</a>

    <?php if ($isLoggedIn): ?>
        <a href="/dashboard">Dashboard</a>

        <form method="POST" action="/logout" class="logout-form">
            <button type="submit">Logout</button>
        </form>
    <?php else: ?>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    <?php endif; ?>
</nav>

<div class="container">