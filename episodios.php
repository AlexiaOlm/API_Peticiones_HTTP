<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick and Morty</title>
    <link rel="stylesheet" href="css/episodios.css">
</head>
<body>
    <h1>Explora Rick and Morty</h1>
    <h4>Episodios de Rick and Morty</h4>

    <?php
        $url = "https://rickandmortyapi.com/api/episode";
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: Episodes/1.0',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        if(curl_errno($ch)) {
            echo "Error en cuRL: " . curl_error($ch);
        } else {
            $data = json_decode($response, true);
            foreach($data['results'] as $episode) {
                echo '<form action="personajes.php" method="post">';
                echo '<input type="hidden" name="capitulo" value="' . $episode['name'] . '">';
                echo '<button type="submit">';
                echo $episode["name"] . ' (' . $episode['episode'] . ') - ' . $episode['air_date'];
                echo '</button> <br>';
                echo '</form><br>';
            }
        }
        curl_close($ch);
    ?>
</body>
</html>