<?php

$db = new PDO('mysql:host=localhost;dbname=cyberpunk_db', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
]);

$find = false;
$data = array("name" => "Personnage introuvable");
if (isset($_GET["id"])) {
    $id = $_GET['id'];

    $query = $db->prepare('SELECT p.*, a.*, l.* FROM personnages AS p
    INNER JOIN personnages_affi_location AS pal ON p.id = pal.personnage_id
    INNER JOIN affiliations AS a ON pal.affiliation_id = a.id
    inner join locations as l on pal.location_id = l.id
   where p.id = :id');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $character = $query->fetch();

    if ($character) {
        $find = true;
        $data = $character;
    }
}
$data["headerTitle"] = "{$data["name"]} - Cyberpunk";

if($data["age"]==null){
$data["age"]="inconnu";
}

if ($data["name_affi"] == "Aucune"){
    $data["name_affi"] = null;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data["headerTitle"] ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&family=Source+Code+Pro:wght@300&display=swap" rel="stylesheet">
    <link href="//db.onlinewebfonts.com/c/a082fd3df68a0b54e0d4d794bc38d268?family=Blender+Pro" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/main.css">
</head>

<body>


    <?php if ($find) { ?>
        <div class="container"> 
        <div class="mainContainer">

            <div class="leftContainer">
                <img src="./img/perso_images/<?= $data["image"] ?>.jpg" alt="">
                


            </div>
            <div class="rightContainer">
                <h1><?= $data["name"]; ?></h1>

                <div class="idInfo">
                    <p><span>Age :</span> <?= $data["age"] ?></p>
                    <p><span>Sexe :</span> <?= $data["gender"] ?></p>
                </div>

                <div class="description">
                    <p><?= $data["description"] ?></p>
                </div>

            </div>


        </div>
        <div class="footerCharacter">
            <a class="pulseBack" href="/projet_cyberpunk/index.php">
                < </a>
           <div class="logoAffi"><img class="affi_Logo" src="./img/logoaffiliation/<?= $data["logo"] ?>.PNG" alt="">
           <p><?= $data["name_affi"] ?></p>   
        </div> 
            
                    <div class="location">
                        <img src="./img/locations/<?= $data["image_location"] ?>.jpg" alt="">
                        <p><?= $data["name_location"] ?></p>
                    </div>
        </div>
    </div>
    <?php
    } else {
    ?>
        <h1><?= $data["name"] ?></h1>

    <?php } ?>

</body>

</html>