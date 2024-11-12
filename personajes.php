<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick and Morty</title>
    <link rel="stylesheet" href="css/personajes.css">
</head>
<body>
    <?php
    session_start();
    $episodio = '';
    if(isset($_POST['capitulo'])) {
        $episodio = $_POST['capitulo'];
        $_SESSION['episodio'] = $episodio;
    }
    $episodio = $_SESSION['episodio'];
    //echo $episodio;
    ?>

    <h1>Explora Rick and Morty</h1>
    <h4>Personajes en <?php echo $episodio; ?></h4>

    <?php
    function obtenerArrayPersonajes($episodio) {
        $personajes = [];
        $episodio_c = str_replace(' ', '%20', $episodio);
        $ruta = "https://rickandmortyapi.com/api/episode?name=" . $episodio_c;
        $url = $ruta;
        //echo $url;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: personajes/1.0',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        if(curl_errno($ch)) {
            echo "Error en cuRL: " . curl_error($ch);
        } else {
            $data = json_decode($response, true);
            if (isset($data['results']) && !empty($data['results'])) {
                foreach($data['results'] as $episodio) {
                    if (isset($episodio['characters']) && !empty($episodio['characters'])) {
                        $personajes = $episodio['characters'];
                    }
                }
            } else {
                echo "<p>No se encontraron resultados para el episodio </p>";
            }
        }
        curl_close($ch);
        return $personajes;
    }
    $personajes = obtenerArrayPersonajes($episodio);

    function imprimirPersonajes($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: personajes/1.0',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        if(curl_errno($ch)) {
            echo "Error en CURL: " . curl_error($ch);
        } else {
            $data = json_decode($response, true);
            echo "<div>";
            echo "<img src='" . $data['image'] . "'>";
            echo "<a href='ficha_detallada.php?id=" . $data['id'] . "'>" . $data['name'] . "</a>";
            echo "</div>";
        }
    }

    echo "<section>";
    for($i=0; $i<count($personajes); $i++) {
        imprimirPersonajes($personajes[$i]);
        //echo $personajes[$i];
    }
    echo "</section>";
    ?>
    <form action="episodios.php" method="post">
        <button>Volver a Episodios</button>
    </form>
</body>
</html>