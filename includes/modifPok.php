<form action="index.php" method="post" class="modifPokForm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $id;?>">
    <div class="form-group">
        <label for="num">Numéro:</label>
        <input type="text" id="num" value="<?= $_SESSION['numero'];?>"  name="numero">
    </div>
    <div class="form-group">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" value="<?= $_SESSION['name'];?>" name="name">
    </div>
    <div class="form-group">
        <label for="type1">Type 1:</label>
        <input type="text" id="type1" value="<?= $_SESSION['type1'];?>" name="type1">
    </div>
    <div class="form-group">
        <label for="type2">Type 2:</label>
        <input type="text" id="type2" value="<?= $_SESSION['type2'];?>" name="type2">
    </div>
    <div class="form-group">
        <label for="evo1">Evolution 1:</label>
        <select id="evo1" name="evo1">
            <option value="<?= $_SESSION['evo1']; ?>"><?= $_SESSION['evo1']; ?></option>
            <?php
            $sql = "SELECT name FROM pokemons";
            $q = $conn->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($q as $pokemon) {
                echo "<option value='" . $pokemon['name']. "'>" . $pokemon['name']. "</option>";
            }

            ?>
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="evo2">Evolution 2:</label>
        <select id="evo2" name="evo2">
            <option value="<?= $_SESSION['evo2']; ?>"><?= $_SESSION['evo2']; ?></option>
            <?php
            $sql = "SELECT name FROM pokemons";
            $q = $conn->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($q as $pokemon) {
                echo "<option value='" . $pokemon['name']. "'>" . $pokemon['name']. "</option>";
            }

            ?>
            ?>
        </select>
    </div>
    <div class="form-group">
        <input type="file" value="<?= $_SESSION['imagePok'];?>" name="image">
    </div>
    <button type="submit" class="btn" name="modifPokemon">Modifier Pokemon</button>
</form>