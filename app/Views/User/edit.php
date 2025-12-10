<h2>Edit User</h2>

<form action="/users/update" method="POST">
    <!-- Hidden field for user ID -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>">

    <div>
        <label for="role_id">Role ID:</label>
        <input type="number" name="role_id" id="role_id" value="<?php echo htmlspecialchars($user->role_id, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div>
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($user->full_name, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div>
        <label for="password">Password (leave blank to keep current):</label>
        <input type="password" name="password" id="password">
    </div>
    
    <div>
        <button type="submit">Update User</button>
    </div>
</form>
