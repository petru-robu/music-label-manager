<?php
require_once __DIR__ . '/../../Models/Artist.php';
require_once __DIR__ . '/../../Models/User.php';

$artist = Artist::getArtistById($artist_id);
$stage_name = $artist ? $artist->stage_name : 'Unknown Artist';

function fetchAlbumInfo($albumTitle, $artistName)
{
    // --- Wikipedia Helper ---
    $searchWikipedia = function ($query)
    {
        $url = "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($query) . "&format=json";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "AlbumParser/1.0 (example@example.com)");
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$response || $httpCode !== 200)
            return null;

        $data = json_decode($response, true);
        if (!empty($data['query']['search'][0]))
        {
            $title = $data['query']['search'][0]['title'];
            $snippet = html_entity_decode(strip_tags($data['query']['search'][0]['snippet']), ENT_QUOTES, 'UTF-8');
            $url = "https://en.wikipedia.org/wiki/" . str_replace(' ', '_', $title); // link to article

            return [
                'source' => 'Wikipedia',
                'title' => $title,
                'snippet' => $snippet,
                'url' => $url
            ];
        }
        return null;
    };
    // --- MusicBrainz Helper ---
    $fetchMusicBrainz = function ($albumTitle, $artistName)
    {   
        // https://musicbrainz.org/search?query=master+of+puppets&type=artist&method=indexed
        $query = urlencode("$albumTitle $artistName");
        $url = "https://musicbrainz.org/search?query=$query&method=indexed";

        //echo $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "AlbumParser/1.0 (example@example.com)");
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$response || $httpCode !== 200)
            return null;

        $data = json_decode($response, true);
        if (!empty($data['releases'][0]))
        {
            $release = $data['releases'][0];

            $info = [
                'source' => 'MusicBrainz',
                'title' => $release['title'] ?? $albumTitle,
                'artist' => $artistName,
                'release_date' => $release['date'] ?? 'Unknown',
                'country' => $release['country'] ?? 'Unknown',
                'url' => "https://musicbrainz.org/release/" . $release['id']
            ];

            // Optional: include track count and status
            if (!empty($release['track-count']))
                $info['track_count'] = $release['track-count'];
            if (!empty($release['status']))
                $info['status'] = $release['status'];

            return $info;
        }
        return null;
    };


    // --- Fetch Wikipedia info first ---
    $info = $searchWikipedia("$albumTitle $artistName album") ?? $searchWikipedia($albumTitle);

    // --- Fetch MusicBrainz info ---
    $mbInfo = $fetchMusicBrainz($albumTitle, $artistName);
    if ($mbInfo)
    {
        $info['musicbrainz'] = $mbInfo;
    }

    if (!$info)
    {
        return [
            'title' => $albumTitle,
            'snippet' => "No external info found.",
            'url' => "#"
        ];
    }

    return $info;
}

$info = fetchAlbumInfo($album->title, $artist->stage_name);
//var_dump($info);
?>

<h4>External Album Info</h4>
<strong><?= htmlspecialchars($info['title']) ?></strong><br>
<?= $info['snippet'] ?? '' ?><br>
<a href="<?= htmlspecialchars($info['url']) ?>" target="_blank">View on <?= $info['source'] ?></a><br>

