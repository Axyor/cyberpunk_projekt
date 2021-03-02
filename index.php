<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&family=Source+Code+Pro:wght@300&display=swap" rel="stylesheet">
    <link href="//db.onlinewebfonts.com/c/a082fd3df68a0b54e0d4d794bc38d268?family=Blender+Pro" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/main.css">

    <title>CyberPunk Projekt</title>
</head>

<?php

$db = new PDO('mysql:host=localhost;dbname=cyberpunk_db', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
]);

$query = $db->query("SELECT p.* FROM personnages  AS p
ORDER BY p.name desc ;");
$characters = $query->fetchAll();

?>


<body>
    <main>
        <header>

            <div class="titleImage">
                <img src="./img/title_Image.png" alt="">
            </div>

            <div class="formInput">
                <input class="inputChamp" type="text" placeholder="Saisissez une donnée" id="search">
            </div>
        </header>
        <div class="presentation">
            <p class="line anim-typewriter"> &#x201F; Hellooooo Night-City !!! &#x201D; </p>

        </div>
        <div class="poster-characters">
            <?php
            foreach ($characters as $character) {

            ?>
                <div class="character">
                    <a href="character.php?id=<?= $character["id"] ?>">
                        <img src="./img/perso_poster/<?= $character["poster"] ?>.jpg" alt="">


                        <p><?= $character["name"] ?></p>
                    </a>

                </div>
            <?php
            }
            ?>
        </div>

        <footer>
            <p class="copyR"> <span>&#xA9;</span> Cd Projekt Red </p>

            <p class="IdCreator">Fan projekt by <a href="https://alexandre-roy.web.app/" target="_blank"> Alexandre ROY</a></p>
        </footer>
        <script src="js/main.js"></script>
    </main>
</body>

</html>