<h2>Register as an Artist</h2>

<?php if (!empty($error)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="/register_artist">

    <p>User account information:</p>
    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <p>Artist information:</p>
    <input type="text" name="stage_name" placeholder="Stage Name" required>
    <input type="text" name="bio" placeholder="Biography" required>

    <div style="margin-top:10px;">
        <img src="/captcha.php" alt="CAPTCHA">
        <input type="text" name="captcha" placeholder="Enter CAPTCHA" required style="display:block; margin-top:5px;">
    </div>

    <button type="submit">Register</button>
</form>