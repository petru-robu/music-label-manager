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

    <style>
        #top-pages-chart svg text {
            font-size: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <?php if ($isLoggedIn): ?>
            <a href="/dashboard">Dashboard</a>

            <?php if ($username): ?>
                <span class="user-name"><?php echo $username; ?></span>
            <?php endif; ?>

            <form method="POST" action="/logout" class="logout-form">
                <button type="submit">Logout</button>
            </form>
        <?php else: ?>
            <a href="/">Home</a>
            <a href="/login">Login</a>
        <?php endif; ?>
    </nav>

    <div class="container">