<form action="index.php" method="post" enctype="multipart/form-data">
    <h4>Ajouter un pokémon</h4>
    <div class="form-group">
        <input type="text" placeholder="Numéro" name="numero">
    </div>
    <div class="form-group">
        <input type="text" placeholder="name"name="name">
    </div>
    <div class="form-group">
        <input type="text" placeholder="type1" name="type1">
    </div>
    <div class="form-group">
        <input type="text" placeholder="type2" name="type2">
    </div>
    <div class="form-group">
        <label for="evo1">Evolution 1:</label>
        <select id="evo1" name="evo1">
            <option value="">Evolution 1</option>
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
            <option value="">Evolution 2</option>
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
        <input type="file" placeholder="Image"name="image">
    </div>
    <button type="submit" class="btn" name="submitPokemon">Ajouter Pokemon</button>
</form>