<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Models/User.php';

class ArtistController extends Controller
{
    private $artistModel;

    public function __construct()
    {
        $this->artistModel = new Artist();
    }

    // HELPERS
    private function requireUser()
    {
        // require logged in user
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id)
        {
            http_response_code(403);
            echo "Unauthorized.";
            return null;
        }
        return (int)$user_id;
    }

    private function requireArtistOwner($artist_id)
    {
        // check if logged in artist is artist from route
        $user_id = $this->requireUser();
        if (!$user_id)
            return null;

        $artist = $this->artistModel->getArtistById((int)$artist_id);
        if (!$artist || (int)$artist->user_id !== $user_id)
        {
            http_response_code(403);
            echo "Unauthorized artist.";
            return null;
        }

        return $artist;
    }

    private function getRequestId()
    {
        // get id from post / get
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            return $_POST['id'] ?? null;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            return $_GET['id'] ?? null;
        }
        return null;
    }

    private function redirectIndex()
    {
        // redirect to index
        header('Location: /artists');
        exit;
    }

    // ACTIONS
    public function index()
    {
        // list all artists
        if (!$this->requireUser())
            return;

        $artists = $this->artistModel->getAll();
        $this->render('Artist/index', ['artists' => $artists]);
    }

    public function edit()
    {
        // show the edit form
        $id = $this->getRequestId();
        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: Artist ID is required.";
            return;
        }

        if (!$artist = $this->requireArtistOwner($id))
            return;

        $this->render('Artist/edit', ['artist' => $artist]);
    }

    public function update()
    {
        // update an artist
        if (!$this->requireUser())
            return;

        $id = $_POST['id'] ?? null;
        $stage_name = $_POST['stage_name'] ?? null;
        $bio = $_POST['bio'] ?? '';

        if (!$id || !$stage_name)
        {
            http_response_code(400);
            echo "Bad Request: Missing required fields.";
            return;
        }

        if (!$artist = $this->requireArtistOwner($id))
            return;

        $updated = $this->artistModel->updateArtist(
            $artist->id,
            $artist->user_id,
            $stage_name,
            $bio
        );

        if ($updated)
        {
            $this->redirectIndex();
        }

        http_response_code(500);
        echo "Failed to update artist.";
    }

    public function delete()
    {
        // delete an artist
        $id = $this->getRequestId();
        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: Artist ID is required.";
            return;
        }

        if (!$artist = $this->requireArtistOwner($id))
            return;

        if ($this->artistModel->deleteArtist($artist->id))
        {
            $this->redirectIndex();
        }

        http_response_code(404);
        echo "Artist not found or could not be deleted.";
    }

    public function editProfile()
    {
        // render the edit form
        $userId = $_SESSION['user_id'];

        $artist = Artist::getByUserId($userId);
        $user = User::getUserById($userId); // assuming you have a User model

        if (!$artist || !$user)
        {
            http_response_code(404);
            echo "Profile not found.";
            return;
        }

        $this->render('Artist/editProfile', [
            'artist' => $artist,
            'user' => $user
        ]);
    }

    public function updateProfile()
    {
        $userId = $_SESSION['user_id'];
        $artist = Artist::getByUserId($userId);
        $user = User::getUserById($userId);

        if (!$artist || !$user)
        {
            http_response_code(404);
            echo "Profile not found.";
            return;
        }

        // Get user inputs
        $username = trim($_POST['username'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $stage_name = trim($_POST['stage_name'] ?? '');
        $bio = trim($_POST['bio'] ?? '');

        // Validate required fields
        if ($name === '' || $email === '' || $stage_name === '')
        {
            http_response_code(400);
            echo "Name, email, and stage name are required.";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            http_response_code(400);
            echo "Invalid email address.";
            return;
        }
        // Only update password if it's not empty
        if($password)
            User::updateUser($userId, $user->role_id, $username, $name, $email, $password);
        else
            User::updateUser($userId, $user->role_id, $username, $name, $email);

        // Update artist
        Artist::updateArtist($artist->id, $userId, $stage_name, $bio);

        header('Location: /artist/dashboard');
        exit;
    }

}
