<h1>
    Admin Dashboard
    
</h1>
<h2>
   Welcome, 
    <span style="color: grey">
    <?php
        echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
    ?></span>
</h2>

<p> 
    This is your dashboard. From here you can manage your account and do
    all your actions.
</p>

<div>
    <a href="/users">Manage users</a> <br />
</div>

