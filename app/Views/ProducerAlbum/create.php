<?php
    require_once __DIR__ . '/../../Models/User.php';
    require_once __DIR__ . "/../../Models/Producer.php";

    if ($isLoggedIn)
    {
        $user_id = $_SESSION['user_id'];
        $user = User::getUserById($userId);
        if ($user)
            $username = $user->username ?? '';

        $producer = Producer::getByUserId($user_id);
    }
?>

<h1>Produce an Album</h1>

<form method="POST" action="/producer/<?= $producer->id ?>/album/store">
    <div>
        <label for="artist-select">Select Artist:</label>
        <select id="artist-select" name="artist_id" required>
            <option value="">--Select Artist--</option>
            <?php foreach ($artists as $artist): ?>
                <option value="<?= $artist['id'] ?>"><?= htmlspecialchars($artist['stage_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="album-select">Select Album:</label>
        <select id="album-select" name="album_id" required>
            <option value="">--Select Album--</option>
        </select>
    </div>

    <button type="submit">Add Production</button>
</form>

<script>
    // Preload albums data in JS
    const albumsByArtist = <?php
    $jsArray = [];
    foreach ($albumsByArtist as $artistId => $albums)
    {
        $jsArray[$artistId] = array_map(function ($album)
        {
            return ['id' => $album['id'], 'title' => $album['title']];
        }, $albums);
    }
    echo json_encode($jsArray);
    ?>;

    const artistSelect = document.getElementById('artist-select');
    const albumSelect = document.getElementById('album-select');

    artistSelect.addEventListener('change', function () {
        const selectedArtistId = this.value;

        // Clear previous options
        albumSelect.innerHTML = '<option value="">--Select Album--</option>';

        if (albumsByArtist[selectedArtistId]) {
            albumsByArtist[selectedArtistId].forEach(album => {
                const option = document.createElement('option');
                option.value = album.id;
                option.textContent = album.title;
                albumSelect.appendChild(option);
            });
        }
    });
</script>