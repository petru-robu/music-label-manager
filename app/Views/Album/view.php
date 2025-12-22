<?php
require_once __DIR__ . '/../../Models/Artist.php';
require_once __DIR__ . '/../../Models/User.php';

$artist = Artist::getArtistById($artist_id);
$stage_name = $artist ? $artist->stage_name : 'Unknown Artist';

function fetchAlbumInfo($albumTitle, $artistName)
{
    // Helper function to perform Wikipedia search
    $searchWikipedia = function ($query)
    {
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
    };

    // First try: album + artist
    $info = $searchWikipedia("$albumTitle $artistName album");
    if ($info !== null)
    {
        return $info;
    }

    // Fallback: just album title
    $info = $searchWikipedia($albumTitle);
    if ($info !== null)
    {
        return $info;
    }

    return [
        'title' => $albumTitle,
        'snippet' => "No external info found, showing album title.",
        'url' => "#"
    ];
}

$info = fetchAlbumInfo($album->title, $artist->stage_name);
?>

<h4>External Info (Wikipedia Search)</h4>

Title: <?= htmlspecialchars($info['title']) ?><br />
Snippet: <?= htmlspecialchars($info['snippet']) ?><br />
Link: <a href="<?= htmlspecialchars($info['url']) ?>" target="_blank">View on Wikipedia</a><br />