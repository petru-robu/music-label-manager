<h2>Send us an email:</h2>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
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

    <button type="submit">Send</button>
</form>