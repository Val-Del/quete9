<form action="index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $id;?>">
    <div class="form-group">
        <input type="text" value="<?= $_SESSION['champion'];?>"  name="champion">
    </div>
    <div class="form-group">
        <input type="text" value="<?= $_SESSION['ville'];?>"name="ville">
    </div>
    <div class="form-group">
        <input type="text" value="<?= $_SESSION['type'];?>" name="type">
    </div>
    <div class="form-group">
        <input type="text" value="<?= $_SESSION['badge'];?>" name="badge">
    </div>
    <div class="form-group">
        <input type="file" value="<?= $_SESSION['image'];?>"name="image">
    </div>
    <button type="submit" class="btn" name="modifChampion">Modifier Champion</button>
</form>