<h2>Login</h2>

<?php if (!empty($error)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="/login">
    <input type="email" name="email" placeholder="Enter your email" required>
    <input type="password" name="password" placeholder="Enter your password" required>

    <div>
        <img src="/captcha.php" alt="CAPTCHA">
        <input type="text" name="captcha" placeholder="Enter CAPTCHA" required style="display:block; margin-top:5px;">
    </div>

    <button type="submit">Login</button>
</form>
