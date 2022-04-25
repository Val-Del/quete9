<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$test = "è ò ù";
echo htmlspecialchars($test, ENT_QUOTES, 'UTF-8');
include 'includes/db.php';
include 'includes/nav.php';
if (isset($_GET['submitSearch'])) {
    $keyword = htmlspecialchars($_GET['keyword'], ENT_QUOTES, 'UTF-8');
    $q = "(SELECT * FROM pokemons WHERE name LIKE '%{$keyword}%')
   UNION
   (SELECT * FROM champions WHERE champion LIKE '%{$keyword}%') 
   ORDER BY name ASC";

  $q = $conn->query($q);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    $r = 0;
    foreach ($q as $result) {
        $r++;
//        echo $r . '<br>';
        echo 'numéro: ' .$result['numero'] . '<br>';
        echo 'name: ' .$result['name'] . '<br>';
        echo 'type1: ' .$result['type1'] . '<br>';
        echo 'type2: ' .$result['type2'] . '<br><br>';


    }
    echo '<h3>' . $r . ' résultats </h3><br>';
}




?>
</body>
</html>