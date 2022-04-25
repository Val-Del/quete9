<?php
session_start();
include 'includes/db.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php  include 'includes/nav.php'?>
<!---------------------SEARCH----------------------->
<!--<div class="container">-->
<!--    <div class="row">-->
<?php
if (isset($_GET['submitSearch'])) {
    $keyword = htmlspecialchars($_GET['keyword'], ENT_QUOTES, 'UTF-8');
//    $q = "(SELECT * FROM pokemons WHERE name LIKE '%{$keyword}%')
//   UNION
//   (SELECT * FROM champions WHERE champion LIKE '%{$keyword}%')
//   ORDER BY name ASC";

    $q = "SELECT * FROM champions WHERE champion LIKE '%{$keyword}%' OR ville LIKE '%{$keyword}%' OR type LIKE '%{$keyword}%' OR badge LIKE '%{$keyword}%'";

    $q = $conn->query($q);
    $q->setFetchMode(PDO::FETCH_ASSOC);
//    $count = $q->setFetchMode(PDO::FETCH_ASSOC);
    $r = 0;
    ?>
<div class="container">
    <div class="row">
<?php
    foreach ($q as $champion) {
        $r++;
        echo "<div class=\"col\">";
        echo "<form action=\"index.php\" method=\"POST\"><input type=\"hidden\"value='".$champion['id']. "' name=\"id\"><button type=\"submit\" name=\"detailsChamp\">";
        echo "<div class=\"card\" style=\"width: 18rem;\">";
        echo "<input type=\"hidden\"value='".$champion['image']. "' name=\"image\"><figure><img src='" . $champion['image']."'></figure>";
        echo "<div class=\"card-body\">";
        echo "<input type=\"hidden\"value='".$champion['champion']. "' name=\"champion\"><p>Champion: " .$champion['champion']. '</p>';
        echo "<input type=\"hidden\"value='".$champion['ville']. "' name=\"ville\"><p>Ville: " .$champion['ville']. '</p>';
        echo "<input type=\"hidden\"value='".$champion['type']. "' name=\"type\"><p>Type: " .$champion['type']. '</p>';
        echo "<input type=\"hidden\"value='".$champion['pokemon1']. "' name=\"pok1\">";
        echo "<input type=\"hidden\"value='".$champion['pokemon2']. "' name=\"pok2\">";
        echo "<input type=\"hidden\"value='".$champion['badge']. "' name=\"badge\"><p>Badge: " .$champion['badge']. '</p>';
        echo "<p class='btn-card'>Champion</p>";
        echo "</div></div></div></button></form>";
    }
//    print "There are " .  $count . " matching records.";
//    echo '<h3>' . $r . ' résultat(s) dans champions </h3><br>';
    ?>
    </div>
</div>
<?php if (isset($_GET['submitSearch'])) { echo '<h3>' . $r . ' résultat(s) dans champions </h3><br>'; }
?>
    <div class="container">
        <div class="row">
    <?php
    $sql = "SELECT * FROM pokemons WHERE name LIKE '%{$keyword}%' OR type1 LIKE '%{$keyword}%' OR numero LIKE '%{$keyword}%' OR type2 LIKE '%{$keyword}%'";
    $q = $conn->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    $r2 = 0;
    foreach ($q as $pokemon) {
        $r2++;
        echo "<div class=\"col\">";
        echo "<form action=\"index.php\" method=\"POST\"><input type=\"hidden\"value='".$pokemon['id']. "' name=\"id\"><button type=\"submit\" name=\"detailsPok\">";
        echo "<div class=\"card\" style=\"width: 18rem;\">";
        echo "<input type=\"hidden\"value='".$pokemon['image']. "' name=\"image\"><figure><img src='" . $pokemon['image']."'></figure>";
        echo "<div class=\"card-body\">";
        echo "<input type=\"hidden\"value='".$pokemon['numero']. "' name=\"numero\"><p>Numéro: " .$pokemon['numero']. '</p>';
        echo "<input type=\"hidden\"value='".$pokemon['name']. "' name=\"name\"><p>Nom: " .$pokemon['name']. '</p>';
        echo "<input type=\"hidden\"value='".$pokemon['type1']. "' name=\"type1\"><p>Type 1: " .$pokemon['type1']. '</p>';
        echo "<input type=\"hidden\"value='".$pokemon['type2']. "' name=\"type2\"><p>Type 2: " .$pokemon['type2']. '</p>';
        echo "<input type=\"hidden\"value='".$pokemon['evolution1']. "' name=\"evo1\">";
        echo "<input type=\"hidden\"value='".$pokemon['evolution2']. "' name=\"evo2\">";
        echo "<p class='btn-card'>Fiche pokémon</p>";
        echo "</div></div></div></button></form>";
    }

}
?>
        </div>
    </div>
<?php if (isset($_GET['submitSearch'])) { echo '<h3>' . $r2 . ' résultat(s) dans pokemons </h3><br>';} ?>

<!-------------------SEARCH FIN---------------------->
<header>
<?php include 'includes/header.php'; ?>
</header>

<!-------------AJOUTER CHAMPION---------------->
<?php
if(isset($_GET['addChampion'])) {
    include 'includes/addChampion.php';
}
if (isset($_POST['addChampion'])) {
    $ville = htmlspecialchars($_POST['ville'], ENT_QUOTES, 'UTF-8');
    $champion = htmlspecialchars($_POST['champion'], ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8');
    $badge = htmlspecialchars($_POST['badge'], ENT_QUOTES, 'UTF-8');
    $poke1 = htmlspecialchars($_POST['poke1'], ENT_QUOTES, 'UTF-8');
    $poke2 = htmlspecialchars($_POST['poke2'], ENT_QUOTES, 'UTF-8');
    $img_path = 'upload/default.jpg';
    $image = $_FILES['image'];
    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tempName = $_FILES['image']['tmp_name'];
    $img_error = $_FILES['image']['error'];
    if (empty($_POST['ville'])) {
        echo "ville à remplir". '<br>';
    }
    if (empty($_POST['champion'])) {
        echo "champion à remplir". '<br>';
    }
//    if (empty($_POST['type'])) {
//        echo "type à remplir". '<br>';
//    }
//    if (empty($_POST['badge'])) {
//        echo "badge à remplir" . '<br>';
//    }

    if ($img_error===0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_exl = strtolower($img_ex);
        $allow_ex = array("jpg", "jpeg", "png");
        if (in_array($img_exl, $allow_ex)) {
            $newImgName = uniqid("IMG-", true).'.'.$img_exl;
            $img_path = 'upload/'.$newImgName;
            move_uploaded_file($tempName, $img_path);

        }else {
            echo "jpeg jpg png seulement";
        }
    }
    if (!empty($_POST['ville']) && !empty($_POST['champion'])) {
        $sql = "INSERT INTO champions (ville, champion, type, badge, image, pokemon1, pokemon2) VALUES (?,?,?,?,?,?,?);";
        $res = $conn->prepare($sql);
        $res->execute( [$ville,
            $champion,
            $type,
            $badge,
            $img_path,
            $poke1,
            $poke2
        ]);
    }


}

?>
<!-------------AJOUTER CHAMPION FIN------------>
<!-------------AJOUTER POKEMON ---------------->

<?php
if(isset($_GET['addPokemon'])) {
    include 'includes/addPokemon.php';
}
if (isset($_POST['submitPokemon'])) {
    $numero = htmlspecialchars($_POST['numero'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $type1 = htmlspecialchars($_POST['type1'], ENT_QUOTES, 'UTF-8');
    $type2 = htmlspecialchars($_POST['type2'], ENT_QUOTES, 'UTF-8');
    $evo1 = htmlspecialchars($_POST['evo1'], ENT_QUOTES, 'UTF-8');
    $evo2 = htmlspecialchars($_POST['evo2'], ENT_QUOTES, 'UTF-8');
    $img_path = 'upload/default.jpg';
    $image = $_FILES['image'];
    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tempName = $_FILES['image']['tmp_name'];
    $img_error = $_FILES['image']['error'];
    if (empty($numero)) {
        echo "numéro à remplir" . '<br>';
    }
//    if (empty($numero)) {
//        echo "numéro à remplir" . '<br>';
//    }
//    if (is_int($numero) == FALSE) {
//        echo "doit être un nombre" . '<br>';
//    }
    if (empty($name)) {
        echo "nom à remplir" . '<br>';
    }



    if ($img_error===0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_exl = strtolower($img_ex);
        $allow_ex = array("jpg", "jpeg", "png");
        if (in_array($img_exl, $allow_ex)) {
            $newImgName = uniqid("IMG-", true).'.'.$img_exl;
            $img_path = 'upload/'.$newImgName;
            move_uploaded_file($tempName, $img_path);

        }else {
            echo "jpeg jpg png seulement";
        }
    }

    if (!empty($_POST['numero']) && !empty($_POST['name']) && !empty($_POST['type1'])) {
        $sql = "INSERT INTO pokemons (numero, name, type1, type2, image, evolution1, evolution2) VALUES (?,?,?,?,?,?,?);";
        $res = $conn->prepare($sql);
        $res->execute( [$numero,
            $name,
            $type1,
            $type2,
            $img_path,
            $evo1,
            $evo2
        ]);
    }


}

?>

<!-------------AJOUTER POKEMON FIN------------>

<!-------------CHAMPION VUE- AFFICHAGE------------->
<div class="center">
<div class="container-fluid">
    <div class="row">
<?php
if (isset($_GET['champion'])) {
            try {


                $sql = 'SELECT * FROM champions';
                $q = $conn->query($sql);
                $q->setFetchMode(PDO::FETCH_ASSOC);
                foreach ($q as $champion) {
                    echo "<div class=\"col\">";
                    echo "<form action=\"index.php\" class='formCard' method=\"POST\"><input type=\"hidden\"value='".$champion['id']. "' name=\"id\"><button type=\"submit\" name=\"detailsChamp\">";
                    echo "<div class=\"card\">";
                    echo "<input type=\"hidden\"value='".$champion['image']. "' name=\"image\"><figure><img src='" . $champion['image']."'></figure>";
                    echo "<div class=\"card-body\">";
                    echo "<input type=\"hidden\"value='".$champion['champion']. "' name=\"champion\"><p>Champion:<i> " .$champion['champion']. '</i></p>';
                    echo "<input type=\"hidden\"value='".$champion['ville']. "' name=\"ville\"><p>Ville: <i>" .$champion['ville']. '</i></p>';
                    echo "<input type=\"hidden\"value='".$champion['type']. "' name=\"type\"><p>Type: <i>" .$champion['type']. '</i></p>';
                    echo "<input type=\"hidden\"value='".$champion['pokemon1']. "' name=\"pok1\">";
                    echo "<input type=\"hidden\"value='".$champion['pokemon2']. "' name=\"pok2\">";
                    echo '<p>Pokémon 1: <i>' .$champion['pokemon1']. '</i></p>';
                    echo '<p>Pokémon 2: <i>' .$champion['pokemon2']. '</i></p>';
                    echo "<input type=\"hidden\"value='".$champion['badge']. "' name=\"badge\"><p>Badge:<i> " .'</i></p>';
//                    .$champion['badge'].
                    if ($champion['badge'] == 'Badge Roche') {
                        echo "<figure class='badge-champ'><img class='badge-champ' src='imgs/badges/Badge_Roche_Kanto.png'></figure>";
                    }
                    if ($champion['badge'] == 'Badge cascade') {
                        echo "<figure class='badge-champ'><img class='badge-champ' src='imgs/badges/Badge_Cascade_Kanto.png'></figure>";
                    }
                    if ($champion['badge'] == 'Badge foudre') {
                        echo "<figure class='badge-champ'><img class='badge-champ' src='imgs/badges/Badge_Foudre_Kanto.png'></figure>";
                    }
                    if ($champion['badge'] == 'Badge prisme') {
                        echo "<figure class='badge-champ'><img class='badge-champ' src='imgs/badges/Badge_Prisme_Kanto.png'></figure>";
                    }
                    if ($champion['badge'] == 'Badge âme') {
                        echo "<figure class='badge-champ'><img class='badge-champ' src='imgs/badges/35px-Badge_Âme_Kanto.png'></figure>";
                    }
                    if ($champion['badge'] == 'Badge marais') {
                        echo "<figure class='badge-champ'><img class='badge-champ' src='imgs/badges/Badge_Marais_Kanto.png'></figure>";
                    }
                    if ($champion['badge'] == 'Badge volcan') {
                        echo "<figure class='badge-champ'><img class='badge-champ' src='imgs/badges/Badge_Volcan_Kanto.png'></figure>";
                    }
                    if ($champion['badge'] == 'Badge terre') {
                        echo "<figure class='badge-champ'><img  src='imgs/badges/Badge_Terre_Kanto.png'></figure>";
                    }
                    if ($champion['badge'] != 'Badge terre' && $champion['badge'] != 'Badge volcan' && $champion['badge'] != 'Badge marais' && $champion['badge'] != 'Badge âme' && $champion['badge'] != 'Badge prisme' && $champion['badge'] != 'Badge foudre' && $champion['badge'] != 'Badge cascade' && $champion['badge'] != 'Badge Roche')  {
                        echo "<figure class='badge-champ'><img  src='imgs/badges/question-mark-draw.png'></figure>";
                    }
//                    if ($champion['badge'] != 'Badge terre' || $champion['badge'] == 'Badge volcan' || $champion['badge'] == 'Badge marais' || $champion['badge'] == 'Badge âme' || $champion['badge'] == 'Badge prisme' || $champion['badge'] == 'Badge foudre' || $champion['badge'] == 'Badge cascade' || $champion['badge'] == 'Badge Roche')  {
//                        echo "<figure class='badge-champ'><img  src='imgs/badges/question-mark-draw.png'></figure>";
//                    }

                    echo "<p class='btn-card'>Champion</p>";
                    echo "</div></div></div></button></form>";
                }

            } catch (PDOException $e) {
                die("Could not connect to the database $dbname :" . $e->getMessage());
            }
}
?>
    </div>
</div>
    </div>

    <!-------------CHAMPION VUE FIN-------------->
<!-------------CHAMPION DETAILS-------------->
<?php if (isset($_POST['detailsChamp'])) {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
    $champion = htmlspecialchars($_POST['champion'], ENT_QUOTES, 'UTF-8');
    $ville = htmlspecialchars($_POST['ville'], ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8');
    $badge = htmlspecialchars($_POST['badge'], ENT_QUOTES, 'UTF-8');
    $pok1 = htmlspecialchars($_POST['pok1'], ENT_QUOTES, 'UTF-8');
    $pok2 = htmlspecialchars($_POST['pok2'], ENT_QUOTES, 'UTF-8');

    $_SESSION['id'] = $id;
    $_SESSION['champion'] = $champion;
    $_SESSION['ville'] = $ville;
    $_SESSION['type'] = $type;
    $_SESSION['badge'] = $badge;
    $_SESSION['image'] = $image;
    echo "<div class='center'>";
    echo "<div class='detailsPokemons detailsC' id='details'>";

    echo "<form method='post' action='index.php'>";
    echo "<div class=\"card\" >";
    echo "<div class=\"card-body\">";
    echo "<img src='" . $image."'>";
    echo '<p>Champion: '.$champion. '</p>';
    echo '<p>Villa: ' .$ville. '</p>';
    echo '<p>Type: ' .$type. '</p>';
    echo '<p>Badge: ' .$badge. '</p>';
//    echo '<p>Pokémon 1: ' .$pok1. '</p>';
//    echo '<p>Pokémon 2: ' .$pok2. '</p>';
    echo "<input type='hidden' value='" . $id . "' name='id'>";
    echo "<button type='button' class='supprimer' name='idSup' data-toggle=\"modal\" data-target=\"#exampleModal\">Supprimer</button>";
    echo "<button type='submit' class='modifier' name='modifier'>Modifier";
    echo "</button></div></div></form>";

    $sql = "SELECT * FROM pokemons WHERE name='$pok1'";

    $q = $conn->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($q as $pokemon) {
        echo "<form action=\"index.php\" class='formCard' method=\"POST\"><input type=\"hidden\"value='".$pokemon['id']. "' name=\"id\"><button type=\"submit\" name=\"detailsPok\">";
        echo "<div class=\"card\" >";
        echo "<input type=\"hidden\"value='".$pokemon['image']. "' name=\"image\"><figure><img src='" . $pokemon['image']."'></figure>";
        echo "<div class=\"card-body\">";
        echo "<input type=\"hidden\"value='".$pokemon['numero']. "' name=\"numero\"><p>Numéro: <i>" .$pokemon['numero']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['name']. "' name=\"name\"><p>Nom: <i>" .$pokemon['name']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['type1']. "' name=\"type1\"><p>Type 1: <i>" .$pokemon['type1']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['type2']. "' name=\"type2\"><p>Type 2: <i>" .$pokemon['type2']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['evolution1']. "' name=\"evo1\">";
        echo "<input type=\"hidden\"value='".$pokemon['evolution2']. "' name=\"evo2\">";
        echo "<p class='btn-card'>Fiche pokémon</p>";
        echo "</div></div></button></form>";
    }
    $sql = "SELECT * FROM pokemons WHERE name='$pok2'";

    $q = $conn->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($q as $pokemon) {

        echo "<form action=\"index.php\" class='formCard' method=\"POST\"><input type=\"hidden\"value='".$pokemon['id']. "' name=\"id\"><button type=\"submit\" name=\"detailsPok\">";
        echo "<div class=\"card\" >";
        echo "<input type=\"hidden\"value='".$pokemon['image']. "' name=\"image\"><figure><img src='" . $pokemon['image']."'></figure>";
        echo "<div class=\"card-body\">";
        echo "<input type=\"hidden\"value='".$pokemon['numero']. "' name=\"numero\"><p>Numéro: <i>" .$pokemon['numero']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['name']. "' name=\"name\"><p>Nom: <i>" .$pokemon['name']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['type1']. "' name=\"type1\"><p>Type 1: <i>" .$pokemon['type1']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['type2']. "' name=\"type2\"><p>Type 2: <i>" .$pokemon['type2']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['evolution1']. "' name=\"evo1\">";
        echo "<input type=\"hidden\"value='".$pokemon['evolution2']. "' name=\"evo2\">";
        echo "<p class='btn-card'>Fiche pokémon</p>";
        echo "</div></div></button></form>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";

}
?>
<!-- Modal SUPPRIMER-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Es-tu sur de vouloir supprimer?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <form action="index.php" method="post">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary" name="supprimer">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
////////////////SUPPRIMER CHAMPION/////////////
///


if (isset($_POST['supprimer'])) {
    $id = $_SESSION['id'];
    $sql = "DELETE FROM champions WHERE id=?";
    $q = $conn->prepare($sql);
    $q->execute( [$id]);

}
////////////////SUPPRIMER CHAMPION END//////////////
////////////////MODIFIER CHAMPION //////////////////
if (isset($_POST['modifier'])) {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    include 'includes/modifChamp.php';

}

if(isset($_POST['modifChampion'])) {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $champion = htmlspecialchars($_POST['champion'], ENT_QUOTES, 'UTF-8');
    $ville= htmlspecialchars($_POST['ville'], ENT_QUOTES, 'UTF-8');
    $type= htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8');
    $badge= htmlspecialchars($_POST['badge'], ENT_QUOTES, 'UTF-8') ;
    $image = $_FILES['image'];
        $img_path = $_SESSION['image'];
        $img_name = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $tempName = $_FILES['image']['tmp_name'];
        $img_error = $_FILES['image']['error'];
        if ($img_error===0) {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_exl = strtolower($img_ex);
            $allow_ex = array("jpg", "jpeg", "png");
            if (in_array($img_exl, $allow_ex)) {
                $newImgName = uniqid("IMG-", true).'.'.$img_exl;
                $img_path = 'upload/'.$newImgName;
                move_uploaded_file($tempName, $img_path);

            }else {
                echo "jpeg jpg png seulement";

            }
        }




     $sql = "UPDATE champions
     SET ville = ?,
         champion = ?,
         type = ?,
         badge = ?,
         image = ?
     WHERE id=?";
     $q = $conn->prepare($sql);
     $q->execute([$ville,
         $champion,
         $type,
         $badge,
         $img_path,
         $id

     ]);
}

////////////////MODIFIER CHAMPION END//////////////

?>
<!-------------CHAMPION DETAILS FIN---------->
<!-------------POKEMONS AFFICHAGE ---------->
<div class="container-fluid">
    <div class="row center">
        <?php
        if (isset($_GET['pokemons'])) {
            try {


                $sql = 'SELECT * FROM pokemons';
                $q = $conn->query($sql);
                $q->setFetchMode(PDO::FETCH_ASSOC);
                foreach ($q as $pokemon) {
                    echo "<div class=\"col\">";
                    echo "<form action=\"index.php\" class='formCard' method=\"POST\"><input type=\"hidden\"value='".$pokemon['id']. "' name=\"id\"><button type=\"submit\" name=\"detailsPok\">";
                    echo "<div class=\"card\" >";
                    echo "<input type=\"hidden\"value='".$pokemon['image']. "' name=\"image\"><figure><img src='" . $pokemon['image']."'></figure>";
                    echo "<div class=\"card-body\">";
                    echo "<input type=\"hidden\"value='".$pokemon['numero']. "' name=\"numero\"><p>Numéro: <i>" .$pokemon['numero']. '</i></p>';
                    echo "<input type=\"hidden\"value='".$pokemon['name']. "' name=\"name\"><p>Nom: <i>" .$pokemon['name']. '</i></p>';
                    echo "<input type=\"hidden\"value='".$pokemon['type1']. "' name=\"type1\"><p>Type 1: <i>" .$pokemon['type1']. '</i></p>';
                    echo "<input type=\"hidden\"value='".$pokemon['type2']. "' name=\"type2\"><p>Type 2: <i>" .$pokemon['type2']. '</i></p>';
                    echo "<input type=\"hidden\"value='".$pokemon['evolution1']. "' name=\"evo1\">";
                    echo "<input type=\"hidden\"value='".$pokemon['evolution2']. "' name=\"evo2\">";
                    echo "<p class='btn-card'>Fiche pokémon</p>";
                    echo "</div></div></div></button></form>";
                }

            } catch (PDOException $e) {
                die("Could not connect to the database $dbname :" . $e->getMessage());
            }
        }

        ?>
    </div>
</div>
<!-------------POKEMONS AFFICHAGE FIN---------->
<!-------------POKEMONS DETAILS---------->
<?php
if (isset($_POST['detailsPok'])) {

    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $numero = htmlspecialchars($_POST['numero'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $type1 = htmlspecialchars($_POST['type1'], ENT_QUOTES, 'UTF-8');
    $type2 = htmlspecialchars($_POST['type2'], ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
    $evo1 = htmlspecialchars($_POST['evo1'], ENT_QUOTES, 'UTF-8');
    $evo2 = htmlspecialchars($_POST['evo2'], ENT_QUOTES, 'UTF-8');

    $_SESSION['evo1'] = $evo1;
    $_SESSION['evo2'] = $evo2;
    $_SESSION['idPok'] = $id;
    $_SESSION['numero'] = $numero;
    $_SESSION['name'] = $name;
    $_SESSION['type1'] = $type1;
    $_SESSION['type2'] = $type2;
    $_SESSION['imagePok'] = $image;
echo "<div class='center'>";
    echo "<div class='detailsPokemons' id='details'>";
    echo "<form method='post' action='index.php'>";
            echo "<div class=\"card\" >";
            echo "<div class=\"card-body\">";
            echo "<figure><img src='" . $image."'></figure>";
            echo '<p>Numero: <i>' . $numero . '</i></p>';
            echo '<p>Nom: <i>' . $name . '</i></p>';
            echo '<p>Type1: <i>' . $type1 . '</i></p>';
            echo '<p>Type2: <i>' . $type2 . '</i></p>';
//            echo '<p>Evolution 1: <i>' . $evo1 . '</i></p>';
//            echo '<p>Evolution 2: <i>' . $evo2 . '</i></p>';
            echo "<input type='hidden' value='" . $id . "' name='id'>";
            echo "<button type='button' class='supprimer' name='idSupPok' data-toggle=\"modal\" data-target=\"#exampleModal1\">Supprimer</button>";
            echo "<button type='submit' class='modifier' name='modifierPok'>Modifier";
        echo "</button></div></div></form>";

    $sql = "SELECT * FROM pokemons WHERE name='$evo1'";

    $q = $conn->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($q as $pokemon) {
            echo "<form action=\"index.php\" class='formCard' method=\"POST\"><input type=\"hidden\"value='".$pokemon['id']. "' name=\"id\"><button type=\"submit\" name=\"detailsPok\">";
            echo "<div class=\"card\" >";
            echo "<input type=\"hidden\"value='".$pokemon['image']. "' name=\"image\"><figure><img src='" . $pokemon['image']."'></figure>";
            echo "<div class=\"card-body\">";
            echo "<input type=\"hidden\"value='".$pokemon['numero']. "' name=\"numero\"><p>Numéro: <i>" .$pokemon['numero']. '</i></p>';
            echo "<input type=\"hidden\"value='".$pokemon['name']. "' name=\"name\"><p>Nom: <i>" .$pokemon['name']. '</i></p>';
            echo "<input type=\"hidden\"value='".$pokemon['type1']. "' name=\"type1\"><p>Type 1: <i>" .$pokemon['type1']. '</i></p>';
            echo "<input type=\"hidden\"value='".$pokemon['type2']. "' name=\"type2\"><p>Type 2: <i>" .$pokemon['type2']. '</i></p>';
            echo "<input type=\"hidden\"value='".$pokemon['evolution1']. "' name=\"evo1\">";
            echo "<input type=\"hidden\"value='".$pokemon['evolution2']. "' name=\"evo2\">";
            echo "<p class='btn-card'>Fiche pokémon</p>";
            echo "</div></div></button></form>";
        }
    $sql = "SELECT * FROM pokemons WHERE name='$evo2'";

    $q = $conn->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($q as $pokemon) {

        echo "<form action=\"index.php\" class='formCard' method=\"POST\"><input type=\"hidden\"value='".$pokemon['id']. "' name=\"id\"><button type=\"submit\" name=\"detailsPok\">";
        echo "<div class=\"card\" >";
        echo "<input type=\"hidden\"value='".$pokemon['image']. "' name=\"image\"><figure><img src='" . $pokemon['image']."'></figure>";
        echo "<div class=\"card-body\">";
        echo "<input type=\"hidden\"value='".$pokemon['numero']. "' name=\"numero\"><p>Numéro: <i>" .$pokemon['numero']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['name']. "' name=\"name\"><p>Nom: <i>" .$pokemon['name']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['type1']. "' name=\"type1\"><p>Type 1: <i>" .$pokemon['type1']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['type2']. "' name=\"type2\"><p>Type 2: <i>" .$pokemon['type2']. '</i></p>';
        echo "<input type=\"hidden\"value='".$pokemon['evolution1']. "' name=\"evo1\">";
        echo "<input type=\"hidden\"value='".$pokemon['evolution2']. "' name=\"evo2\">";
        echo "<p class='btn-card'>Fiche pokémon</p>";
        echo "</div></div></button></form>";
    }
        echo "</div>";
    echo "</div>";
echo "</div>";

}
?>
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Es-tu sur de vouloir supprimer?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <form action="index.php" method="post">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary" name="supprimerPok">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-------------POKEMONS DETAILS FIN---------->
<!-------------POKEMONS SUPPRIMER---------->
<?php
if (isset($_POST['supprimerPok'])) {
    $id = $_SESSION['idPok'];
    $sql = "DELETE FROM pokemons WHERE id=?";
    $q = $conn->prepare($sql);
    $q->execute( [$id]);

}
?>


<!-------------POKEMONS SUPPRIMER FIN---------->
<!-------------POKEMONS MODIFIER -------------->
<?php

if (isset($_POST['modifierPok'])) {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    include 'includes/modifPok.php';

}

if(isset($_POST['modifPokemon'])) {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $numero = htmlspecialchars($_POST['numero'], ENT_QUOTES, 'UTF-8') ;
    $name=htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $type1=htmlspecialchars($_POST['type1'], ENT_QUOTES, 'UTF-8');
    $type2=htmlspecialchars($_POST['type2'], ENT_QUOTES, 'UTF-8');
    $evo1=htmlspecialchars($_POST['evo1'], ENT_QUOTES, 'UTF-8');
    $evo2=htmlspecialchars($_POST['evo2'], ENT_QUOTES, 'UTF-8');

    $image=$_FILES['image'] ;
    $img_path = $_SESSION['imagePok'];
//    $img_path = 'upload/'.$name.'.png';
    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tempName = $_FILES['image']['tmp_name'];
    $img_error = $_FILES['image']['error'];
    if ($img_error===0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_exl = strtolower($img_ex);
        $allow_ex = array("jpg", "jpeg", "png");
        if (in_array($img_exl, $allow_ex)) {
            $newImgName = uniqid("IMG-", true).'.'.$img_exl;
            $img_path = 'upload/'.$newImgName;
            move_uploaded_file($tempName, $img_path);

        }else {
            echo "jpeg jpg png seulement";

        }
    }





    $sql = "UPDATE pokemons
     SET numero = ?,
         name = ?,
         type1 = ?,
         type2 = ?,
         image = ?,
         evolution1 = ?,
         evolution2 = ?
     WHERE id=?";
    $q = $conn->prepare($sql);
    $q->execute([
        $numero,
        $name,
        $type1,
        $type2,
        $img_path,
        $evo1,
        $evo2,
        $id

    ]);
//    header("Location: index.php?pokemons");

}


?>

<!-------------POKEMONS MODIFIER FIN---------->


<?php include 'includes/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>