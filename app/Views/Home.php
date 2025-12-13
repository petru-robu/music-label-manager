<!DOCTYPE html>
<h1>Music Label Manager</h1>
<p>
    Welcome, this is a platform for managing artist, producers and labels.
    You can register as an artist / producer / listener and join this musical community.
</p>

<p>
    This is a place for music labels to organize their workflow and
    collaboration with artists around the world.
</p>


<h2>Register in the platform</h2>
<div>
    Are you a listener? <a href="/register">Create listener account</a> <br />
    Are you an artist? <a href="/register_artist">Create artist account</a> <br />
    Are you a producer? <a href="/register_artist">Create producer account</a> <br />

    If you already have an account, <a href="/login">login</a>.
</div>

<h2>Demo Users</h2>
<div class="note">
    These are demo accounts. Use the username and the password <strong>1234</strong> to login and test the app.
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
        <tr>
            <td>admin</td>
            <td>Administrator</td>
            <td>admin@example.com</td>
            <td>Admin</td>
        </tr>
        <tr>
            <td>user1</td>
            <td>Default User</td>
            <td>user1@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>mickjagger</td>
            <td>Mick Jagger</td>
            <td>mickjagger@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>davidbowie</td>
            <td>David Bowie</td>
            <td>davidbowie@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>freddiemercury</td>
            <td>Freddie Mercury</td>
            <td>freddiemercury@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>jimmihendrix</td>
            <td>Jimi Hendrix</td>
            <td>jimmihendrix@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>janisjoplin</td>
            <td>Janis Joplin</td>
            <td>janisjoplin@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>elvispresley</td>
            <td>Elvis Presley</td>
            <td>elvispresley@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>johnlennon</td>
            <td>John Lennon</td>
            <td>johnlennon@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>paulmccartney</td>
            <td>Paul McCartney</td>
            <td>paulmccartney@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>robertplant</td>
            <td>Robert Plant</td>
            <td>robertplant@example.com</td>
            <td>User</td>
        </tr>
        <tr>
            <td>ozzyosbourne</td>
            <td>Ozzy Osbourne</td>
            <td>ozzyosbourne@example.com</td>
            <td>User</td>
        </tr>
    </tbody>
</table>


<h2>About the application: </h2>
<p>This application implements a system for artists and producers to interact.
    Key points: <br/>
    An <strong>artist</strong> has many <strong>albums</strong>. <br />
    An <strong>album</strong> consists of <strong>songs</strong>. <br />
    The platform has the following types of accounts: <strong>listener</strong>, <strong>artist</strong>, <strong>producer</strong>.<br/>

    The admin manages the <strong>users</strong>. 

    The artist manages his <strong>songs</strong> and <strong>albums</strong> when he is logged in with
    his artist account. He can create/read/update/delete these resources.
</p>

<p>
    Application flow: <br/>
    <img src="" alt="App flow"/>
</p>

<p>
    Database: <br/>
    <img src="" alt="Database"/>
</p>
