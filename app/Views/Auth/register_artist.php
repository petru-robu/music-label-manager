<h2>Register as an Artist</h2>

<form method="post" action="/register_artist">

    <p>Enter user account inforomation: </p>
    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    
    <p>Enter artist information: </p>
    <input type="text" name="stage_name" placeholder="Stage Name" required>
    <input type="text" name="bio"placeholder="Biography"required>

    <button type="submit">Register</button>
</form>

<p style="padding-top: 10px">
    Already have an account? Login <a href="/login">here</a>.
</p>
