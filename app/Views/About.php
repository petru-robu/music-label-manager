<h1>Demo Users</h1>
<div class="note">
    These are demo accounts. Use the email and the password <strong>1234</strong> to login and test the app.
</div>

<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <!-- Admin -->
        <tr>
            <td>admin</td>
            <td>Administrator</td>
            <td>admin@example.com</td>
            <td>Admin</td>
        </tr>

        <!-- Listeners -->
        <tr>
            <td>listener1</td>
            <td>Listener One</td>
            <td>listener1@example.com</td>
            <td>Listener</td>
        </tr>
        <tr>
            <td>listener2</td>
            <td>Listener Two</td>
            <td>listener2@example.com</td>
            <td>Listener</td>
        </tr>

        <!-- Artists -->
        <tr>
            <td>metallica</td>
            <td>Metallica</td>
            <td>metallica@example.com</td>
            <td>Artist</td>
        </tr>
        <tr>
            <td>ironmaiden</td>
            <td>Iron Maiden</td>
            <td>ironmaiden@example.com</td>
            <td>Artist</td>
        </tr>
        <tr>
            <td>slayer</td>
            <td>Slayer</td>
            <td>slayer@example.com</td>
            <td>Artist</td>
        </tr>
        <tr>
            <td>megadeth</td>
            <td>Megadeth</td>
            <td>megadeth@example.com</td>
            <td>Artist</td>
        </tr>

        <!-- Producers -->
        <tr>
            <td>rickrubin</td>
            <td>Rick Rubin</td>
            <td>rickrubin@example.com</td>
            <td>Producer</td>
        </tr>
        <tr>
            <td>bobrock</td>
            <td>Bob Rock</td>
            <td>bobrock@example.com</td>
            <td>Producer</td>
        </tr>
    </tbody>
</table>



<h1>About the application: </h1>
<p>This application implements a system for artists and producers to interact.
    Key points: <br />
    An <strong>artist</strong> has many <strong>albums</strong>. <br />
    An <strong>album</strong> consists of <strong>songs</strong>. <br />
    The platform has the following types of accounts: <strong>listener</strong>, <strong>artist</strong>,
    <strong>producer</strong>.<br />

    The admin manages the <strong>users</strong>.

    The artist manages his <strong>songs</strong> and <strong>albums</strong> when he is logged in with
    his artist account. He can create/read/update/delete these resources.
</p>

<p>
    <strong>Application flow: </strong><br /> <br />
    <img src="/img/appflow.png" alt="App flow" style="width:700px; height:auto;" />
</p>
<br /> <br /> <br />
<p>
    <strong>Database: </strong><br /> <br />
    <img src="/img/db.png" alt="Database" />
</p>