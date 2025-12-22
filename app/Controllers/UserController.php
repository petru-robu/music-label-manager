<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function index()
    {
        // returns a view of all the users
        $users = $this->userModel->getAll();
        $this->render('User/index', ['users' => $users]);
    }

    public function delete()
    {
        // Get id from POST first, fallback to GET
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
            $id = $_GET['id'];
        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $id = $_POST['id'];
        else
        {
            echo 'Invalid request.';
            exit;
        }

        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: User ID is required.";
            return;
        }
        $id = (int)$id;

        // check to not delete oneself
        $currentUserId = $_SESSION['user_id'];
        if ($id === $currentUserId)
        {
            echo 'Cannot delete yourself. Nice try.';
            exit;
        }

        $deleted = $this->userModel->deleteUser($id);

        if ($deleted)
        {
            // redirect to users list after deletion
            header('Location: /users');
            exit;
        }
        else
        {
            http_response_code(404);
            echo "User not found or could not be deleted.";
        }
    }

    public function update()
    {
        // update an user
        $id = $_POST['id'] ?? null;
        $role_id = $_POST['role_id'] ?? null;
        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;
        $full_name = $_POST['full_name'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$id || !$role_id || !$username || !$email || !$full_name)
        {
            http_response_code(400);
            echo "Bad Request: Missing required fields.";
            return;
        }
        $id = (int)$id;
        $role_id = (int)$role_id;

        // check for not changing role
        $currentUserId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($id);

        if (!$user)
        {
            http_response_code(404);
            echo "User not found.";
            return;
        }
        // Block only if user tries to change his own role
        if ($id === $currentUserId && $role_id !== $user->role_id)
        {
            echo "You cannot change your own role. Nice try.";
            return;
        }

        $updated = $this->userModel->updateUser($id, $role_id, $username, $full_name, $email, $password);

        if ($updated)
        {
            header('Location: /users');
            exit;
        }
        else
        {
            http_response_code(500);
            echo "Failed to update user.";
        }
    }

    public function edit()
    {
        // Get user ID from query parameter
        $id = $_GET['id'] ?? null;

        if (!$id)
        {
            http_response_code(400);
            echo "Bad Request: User ID is required.";
            return;
        }

        $id = (int)$id;

        // Fetch user from database
        $user = $this->userModel->getUserById($id);

        if (!$user)
        {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        // render the edit form view, passing the user
        $this->render('User/edit', ['user' => $user]);
    }

    public function generateReport($id)
    {
        if ($_SESSION['role'] != 1)
        {
            http_response_code(403);
            echo "Unauthorized.";
            return;
        }

        $user = $this->userModel->getUserById((int)$id);
        if (!$user)
        {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        require_once __DIR__ . '/../../vendor/autoload.php';

        $pdf = new FPDF();
        $pdf->AddPage();

        // title
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(0, 12, "User Report", 0, 1, 'C');
        $pdf->Ln(5);

        // general info
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, "General Information", 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, "Full Name: {$user->full_name}", 0, 1);
        $pdf->Cell(0, 8, "Username: {$user->username}", 0, 1);
        $pdf->Cell(0, 8, "Email: {$user->email}", 0, 1);

        if ($user->role_id == 1)
            $pdf->Cell(0, 8, "Role: Admin", 0, 1);
        elseif ($user->role_id == 2)
            $pdf->Cell(0, 8, "Role: Artist", 0, 1);
        elseif ($user->role_id == 3)
            $pdf->Cell(0, 8, "Role: Listener", 0, 1);
        elseif ($user->role_id == 4)
            $pdf->Cell(0, 8, "Role: Producer", 0, 1);


        $pdf->Cell(0, 8, "Created At: {$user->created_at}", 0, 1);
        $pdf->Cell(0, 8, "Updated At: {$user->updated_at}", 0, 1);

        // artist info
        if ($user->role_id == 2)
        {
            require_once __DIR__ . '/../Models/Artist.php';
            $artist = Artist::getByUserId($user->id); // get artist record
            if ($artist)
            {
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(0, 10, "Artist Information", 0, 1);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 8, "Stage Name: {$artist->stage_name}", 0, 1);
                $pdf->MultiCell(0, 8, "Bio: {$artist->bio}");

                // List albums using artist ID
                require_once __DIR__ . '/../Models/Album.php';
                $albumModel = new Album();
                $albums = $albumModel->getByArtistId($artist->id); // use artist->id

                // var_dump($albums);
                if ($albums)
                {
                    $pdf->Ln(3);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(0, 8, "Albums:", 0, 1);
                    $pdf->SetFont('Arial', '', 11);
                    foreach ($albums as $album)
                    {
                        $pdf->Cell(0, 6, "- {$album['title']} ({$album['release_year']}, {$album['genre']})", 0, 1);
                    }
                }
            }
        }

        // Producer Info
        if ($user->role_id == 4)
        {
            require_once __DIR__ . '/../Models/Producer.php';
            $producer = Producer::getByUserId($user->id);
            if ($producer)
            {
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(0, 10, "Producer Information", 0, 1);
                $pdf->SetFont('Arial', '', 12);
                $pdf->MultiCell(0, 8, "Bio: {$producer->bio}");
            }
        }

        // Footer / page info
        $pdf->SetY(-20);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, 'Generated by Music Label Manager Admin Panel', 0, 0, 'C');

        $pdf->Output("user_report_{$user->id}.pdf", 'I');
    }



}