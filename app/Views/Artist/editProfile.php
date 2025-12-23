<h2>Edit Profile</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="POST" action="/artist/profile/update">
    <h2>User Info</h2>

    <label>
        Username:
        <input type="text" name="username" value="<?= htmlspecialchars($user->username ?? '') ?>" required>
    </label>

    <label>
        Name:
        <input type="text" name="name" value="<?= htmlspecialchars($user->full_name ?? '') ?>" required>
    </label>

    <label>
        Email:
        <input type="email" name="email" value="<?= htmlspecialchars($user->email ?? '') ?>" required>
    </label>

    <label>
        Password (leave blank to keep current):
        <input type="password" name="password">
    </label>

    <h2>Artist Info</h2>

    <label>
        Stage Name:
        <input type="text" name="stage_name" value="<?= htmlspecialchars($artist->stage_name ?? '') ?>" required>
    </label>

    <label>
        Bio:
        <textarea name="bio"><?= htmlspecialchars($artist->bio ?? '') ?></textarea>
    </label>

    <button type="submit">Update Profile</button>
    <a href="/dashboard" class="button">Cancel</a>
</form>