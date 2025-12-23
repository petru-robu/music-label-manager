<?php
$roles = [
    1 => 'Admins',
    2 => 'Artists',
    3 => 'Listeners',
    4 => 'Producers',
];

// group users by role_id
$groupedUsers = [];
foreach ($users as $user)
{
    $groupedUsers[$user['role_id']][] = $user;
}
?>

<h2>User List</h2>
<a href="/dashboard">Back to dashboard</a>
<br/>

<?php foreach ($roles as $roleId => $roleName): ?>
    <h3><?= htmlspecialchars($roleName) ?></h3>

    <?php if (empty($groupedUsers[$roleId])): ?>
        <p>No users in this role.</p>
        <?php continue; ?>
    <?php endif; ?>

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
            <?php foreach ($groupedUsers[$roleId] as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['role_id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="/users/edit?id=<?= $user['id'] ?>">Edit</a>
                        <a href="/users/delete?id=<?= $user['id'] ?>"
                            onclick="return confirm('Are you sure you want to delete this user?');">
                            Delete
                        </a>
                        <a href="/users/<?= $user['id'] ?>/report" target="_blank">Generate PDF</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br/>
<?php endforeach; ?>