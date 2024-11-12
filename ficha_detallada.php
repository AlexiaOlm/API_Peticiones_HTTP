<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick and Morty</title>
    <link rel="stylesheet" href="css/ficha.css">
</head>
<body>
    <?php
    $idPersonaje = '';
    if(isset($_GET['id'])) {
        $idPersonaje = $_GET['id'];
        $_SESSION['id'] = $idPersonaje;
    }
    $idPersonaje = $_SESSION['id'];
    ?>

    <h1>Explora Rick and Morty</h1>

    <?php
    function imprimirPersonaje($idPersonaje) {
        $url = "https://rickandmortyapi.com/api/character/" . $idPersonaje;
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
            echo "<h3> Ficha de " . $data['name'] . "</h3>";

            echo "<div>";
            echo "<img src='" . $data['image'] . "'>";
            echo "<span><strong>Especie: </strong>" . $data['species'] . "</span><br>";
            echo "<span><strong>Estado: </strong>" . $data['status'] . "</span><br>";
            echo "<span><strong>Género: </strong>" . $data['gender'] . "</span><br>";
            echo "<span><strong>Origen: </strong>" . $data['origin']['name'] . "</span><br>";
            echo "</div>";
        }
    }
    imprimirPersonaje($idPersonaje);
    ?>
    <form action="personajes.php" method="post">
        <button>Volver a Personajes</button>
    </form>
</body>
</html>