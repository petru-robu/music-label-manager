<h2>Send us an email:</h2>

<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="POST" action="/contact/submit">
    <label>
        Name
        <input type="text" name="name" required>
    </label>

    <label>
        Email
        <input type="email" name="email" required>
    </label>

    <label>
        Message
        <textarea name="message" required></textarea>
    </label>

    <div style="margin-top:10px;">
        <img src="/captcha.php" alt="CAPTCHA">
        <input type="text" name="captcha" placeholder="Enter CAPTCHA" required>
    </div>

    <button type="submit">Send</button>
</form>