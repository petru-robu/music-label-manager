<h2>User List</h2>

<table class="table">
<thead>
    <tr>
        <th>ID</th>
        <th>Role ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Full Name</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['role_id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <a href="/users/edit?id=<?php echo $user['id']; ?>">Edit</a>
                <a href="/users/delete?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
