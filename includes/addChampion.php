<form action="index.php" method="post" enctype="multipart/form-data">
    <h4>Ajouter un champion</h4>
    <div class="form-group">
    <input type="text" placeholder="Champion" name="champion">
    </div>
    <div class="form-group">
    <input type="text" placeholder="Ville"name="ville">
    </div>
    <div class="form-group">
    <input type="text" placeholder="Type" name="type">
    </div>
    <div class="form-group">
    <input type="text" placeholder="Badge" name="badge">
    </div>
    <div class="form-group">
    <input type="file" placeholder="Image"name="image">
    </div>
    <h4>Equipe</h4>
    <div class="form-group">
        <select name="poke1">
            <option value="">--Premier pokémon--</option>
            <?php
            try {


                $sql = 'SELECT name FROM pokemons';
            $q = $conn->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($q as $row) {
                echo $row;
                echo "<option value='" . $row['name']. "'>". $row['name']."</option>";



}

} catch (PDOException $e) {
die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>

        </select>
        <div class="form-group">

            <select name="poke2">
                <option value="">--Second Pokémon--</option>
                <?php
                try {


                    $sql = 'SELECT name FROM pokemons';
                    $q = $conn->query($sql);
                    $q->setFetchMode(PDO::FETCH_ASSOC);
                    foreach ($q as $row) {
                        echo $row;
                        echo "<option value='" . $row['name']. "'>". $row['name']."</option>";



                    }

                } catch (PDOException $e) {
                    die("Could not connect to the database $dbname :" . $e->getMessage());
                }
                ?>

            </select>
    </div>

    <button type="submit" class="btn" name="addChampion">Ajouter Champion</button>
</form>