# Music Label Manager

A web application for managing music labels, producers, and artists.

Branch: **DEVELOPMENT**

## Description
The application should have an interface for artists to add new songs / albums.

## About the application

### MVC Arhitecture
The app follows the MVC software development pattern.

#### Models
Each table in the database has a coresponding model that inherits a base which interacts with the database (via PDO):

```php
require_once __DIR__ . '/../Database.php';
class Model
{
    protected function query(string $sql, array $params = []): \PDOStatement|bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    protected function getById(string $table, int $id): ?array
    {
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        $stmt = $this->query($sql, ['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}
```

#### Views
Each view is inserted into a layout like this: 
```php
class View
{
    public static function render(string $view, array $data = [], string $title = ''): void
    {
        extract($data);

        // every view is put between a layout
        require __DIR__ . '/../Views/Layout/header.php';
        require __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/Layout/footer.php';
    }
}
```

#### Controllers
Controllers implement the actions in the application and render views:
```php
require_once __DIR__ . '/../Core/View.php';
class Controller
{
    protected function render(string $view, array $data = [], string $title = ''): void
    {
        View::render($view, $data, $title);
    }
}
```

A controller is defined by deriving the base above:
```php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Analytics.php';

class AnalyticsController extends Controller
{
    private Analytics $analyticsModel;

    public function __construct()
    {
        $this->analyticsModel = new Analytics();
    }

    public function index()
    {
        // returns the index analytics view

        $totals = Analytics::getTotals();
        $viewsPerDay = Analytics::getViewsPerDay();
        $topPages = Analytics::getTopPages();

        $this->render('Analytics/index', [
            'totals' => $totals,
            'viewsPerDay' => $viewsPerDay,
            'topPages' => $topPages,
        ]);
    }

    public function purgeOld($days = 90)
    {
        // delete old entries
        $deleted = Analytics::purgeOlderThan((int)$days);
        echo "Deleted $deleted old analytics records from $days days ago.";
    }
}
```

### Routing
I have implemented a router in `Router.php` that store all routes in a list by http method and also apply middlewares.
Routes are registered in `web.php` like this:

```php
$router->get('/users/:id/report', 'UserController@generateReport', ['Auth', 'Role:1']);
```

The middleware ensures that routes are accesed role-based.
```php
class Auth
{
    public function handle()
    {
        if (!isset($_SESSION['user_id']))
        {
            header('Location: /login'); // redirect to login
            exit;
        }
    }
}
```

```php
class Role
{
    public function handle($requiredRole)
    {
        $userRole = $_SESSION['role'] ?? null;
        $userRole = "{$userRole}";

        if ($userRole !== $requiredRole)
        {
            http_response_code(403);
            echo "Access denied! You don't have the role for this!";
            exit;
        }
    }
}
```

### Authentication and security
Authentication: 
- Passwords are hashed and stored in the DB.
- The auth system manages the authetication of listeners, artists, producers and admins.

Security:
- Form validation (against SQL injection, form spoofing)
- Captcha for contact and register forms
- Routes that are for privileged users cannot be accesed publicly (in middleware):
```php
if ($userRole !== $requiredRole)
{
    http_response_code(403);
    echo "Access denied! You don't have the role for this!";
    exit;
}
```
- Even if the role is right, you cannot acces resources that are not your own:
```php
// Ensure user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id)
{
    http_response_code(403);
    echo "Unauthorized.";
    return;
}

// Get the artist for the logged-in user
$artist = Artist::getByUserId($user_id);
if (!$artist || $artist->id != (int)$artist_id)
{
    http_response_code(403);
    echo "Unauthorized artist";
    return;
}
```
### Report generation
For generating pdf reports on users O used the `setasign/fpdf` library.
Reports are generated from the UserController like this:
```php
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
```

### Charts, analytics
For generating charts and analytics I used `maantje/charts` library.
```php
<h3>Views per day: </h3>
<?php
$points = [[0, 2], [1, 3]];
$x = 2;
foreach ($viewsPerDay as $row) {
    $y = is_numeric($row['views']) ? (float) $row['views'] : 0;
    array_push($points, [$x, $y]);
    $x += 1;
}
$chart = new Chart(
    series: [
        new Lines(
            lines: [
                new Line(points: $points, color: 'blue')
            ]
        ),
    ],
    width: 750,
    height: 300
);
echo $chart->render();
?>
```

### Content parsing
Content parsing is done to get additional information on albums from wikipedia. It uses curl.

```php
$searchUrl = "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($query) . "&format=json";
$ch = curl_init($searchUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "AlbumParser/1.0 (example@example.com)");
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $httpCode !== 200)
{
    return null;
}

$data = json_decode($response, true);
if (!empty($data['query']['search'][0]))
{
    $title = $data['query']['search'][0]['title'];
    $snippet = html_entity_decode(strip_tags($data['query']['search'][0]['snippet']), ENT_QUOTES, 'UTF-8');
    $url = "https://en.wikipedia.org/wiki/" . urlencode($title);

    return [
        'title' => $title,
        'snippet' => $snippet,
        'url' => $url
    ];
}

return null;
```

### PHP Mailer
There is a contact form from which a user can send an email to the site moderator (me).
I registered an app key in my google account. You need to include this in the `.env`:
```
SMTP_USER=petru.r.robu@gmail.com
SMTP_PASS=
CONTACT_RECEIVER_EMAIL=petru.r.robu@gmail.com
```

## Setup
### Environment Variables

After cloning the repository, create your `.env` file:

```bash
cp .env.example .env
```

`.env.example` contains database configuration and mailer keys:

```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=mydb
DB_USERNAME=myuser
DB_PASSWORD=mypass
DB_SSL_MODE=DISABLED

SMTP_USER=petru.r.robu@gmail.com
SMTP_PASS=
CONTACT_RECEIVER_EMAIL=petru.r.robu@gmail.com
```

> Note: Environment variables can be overridden by those defined in `docker-compose.yml`. Be careful when making changes.

### Docker

The application is fully containerized using Docker.

* `docker-compose.yml` defines containers, networks, and volumes.
* `Dockerfile` sets up PHP and Apache, configures permissions, and exposes the necessary ports.

This setup uses two containers:

* **MySQL Database:** `musiclabel_mysql_db`
* **PHP/Apache:** `musiclabel_apache`

#### Start/Stop the Application

```bash
# Stop and remove containers
sudo docker compose down

# Start containers and rebuild in detached mode
sudo docker compose up -d --build
```

#### Useful Docker Commands

```bash
# List all containers
sudo docker ps -a

# Stop specific containers
sudo docker stop musiclabel_apache musiclabel_mysql_db

# Remove specific containers
sudo docker rm -f musiclabel_apache musiclabel_mysql_db
```

### MySQL Database

Access the MySQL container:

```bash
sudo docker exec -it musiclabel_mysql_db mysql -u root -prootpass
```

Common MySQL commands inside the container:

```sql
SHOW DATABASES;          -- List all databases
USE mydb;                -- Select a database
CREATE DATABASE db_name; -- Create a new database
DROP DATABASE db_name;   -- Delete a database
SHOW TABLES;             -- List tables
DESCRIBE table_name;     -- Show table structure
DROP TABLE table_name;   -- Delete a table
SELECT * FROM table_name;-- Query all records
EXIT;                    -- Exit MySQL
```

### Apache Web Server

Access the Apache container:

```bash
sudo docker exec -it musiclabel_apache /bin/bash
```

#### Apache Virtual Host Configuration
A simple apache configuration for running locally.
```bash
<VirtualHost *:80>
# 1. Set the Document Root to the public folder (the only public-facing directory)
DocumentRoot /app/public

<Directory /app/public>
    # Allow .htaccess files to override settings
    AllowOverride All
    # Require all users to access this directory
    Require all granted
</Directory>

# Log file locations
ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### Running migrations

To run a migration you need to:

Enter the docker container:
```bash
sudo docker exec -it musiclabel_apache /bin/bash
```

Run the php file to apply everything in the migrations folder:
```bash
php app/Commands/migrate.php

```