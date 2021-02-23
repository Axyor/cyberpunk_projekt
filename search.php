<?php
$db = new PDO('mysql:host=localhost;dbname=cyberpunk_db', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
]);

$find = false;
$length = 0;
$limit = 10;

if (isset($_GET["q"])) {
    $find = true;

    $page = isset($_GET["page"]) && !empty($_GET["page"]) ? $_GET["page"] : 1;
    $start = isset($_GET["page"]) && !empty($_GET["page"]) ? $limit * ($_GET["page"] - 1) : 0;

    $searchString = $_GET['q'];
    $query = $db->prepare("SELECT p.* FROM personnages AS p
    
                        WHERE p.name LIKE :name
                        GROUP BY p.id
                        ORDER BY p.name desc
                        LIMIT " . $start . ", " . $limit . "");

    $query->bindValue(':name', "%{$searchString}%", PDO::PARAM_STR);
    $query->execute();
    $data = $query->fetchAll();

    $query = $db->prepare("SELECT COUNT(*) FROM personnages
                        WHERE name LIKE :name");
    $query->bindValue(':name', "%{$searchString}%", PDO::PARAM_STR);
    $query->execute();
    $length = $query->fetch();
    if ($length) {
        $length = $length[0];
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&family=Source+Code+Pro:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>Cyberpunk Projekt</title>
</head>

<body>
<header>
<div class="titleImage">
                <a href="/projet_cyberpunk/index.php"><img src="./img/title_Image.png" alt=""></a>
            </div>
</header>
    <main>

        <div class="search-container">
            <p class="line anim-typewriter"><?= $length ?> <?= $length > 1 ? "entrées" : "entrée" ?> trouvée(s)</p>
            <?php
            if ($find) {
            ?>
                <div class="items">
                    <?php
                    foreach ($data as $personnage) {
                        $personnage["name_affi"] = explode(",", $personnage["affiliation"]);
                        $description = $personnage["description"];
                        if (strlen($description) > 200) {
                            $description = wordwrap($description, 200);
                            $description = substr($description, 0, strpos($description, "\n"));
                            $description .= "...";
                        }
                    ?>
                        <div class="item">
                            <a href="character.php?id=<?= $personnage["id"] ?>">
                                <img src="./img/perso_images/<?= $personnage["image"] ?>.jpg" alt="">
                            </a>
                            <div class="personnage-details">
                                <h3>
                                    <a href="character.php?id=<?= $personnage["id"] ?>"><?= $personnage["name"] ?></a>
                                </h3>
                                <ul>
                                    <?php
                                    foreach ($personnage["name_affi"] as $affiliation) {
                                    ?>
                                        <li class="personnage-affi"><?= $affiliation ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                                <p><?= $description ?></p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                if ($length > $limit) {
                    $pages = ceil($length / $limit);
                   
                ?>
                    <ul class="pagination" unselectable="unselectable">
                        <?php
                        for ($i = 1; $i <= $pages; $i++) {
                        ?>
                            <li class="pagination-item <?= $i == $page ? "active" : "" ?>">
                                <a rel="nofollow" href="search.php?q=<?= $searchString ?>&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
            <?php
                }
            }
            ?>
        </div>

    </main>


</body>

</html>