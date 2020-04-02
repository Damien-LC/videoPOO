<?php
$listeGenres = $selectUserForm[0];
$listeYear = $selectUserForm[1];
?>

<form class="regForm" action="user_pref.php" method="POST">
    <fieldset>
        <legend>>Quels films cherchez-vous :</legend>
        <div class="form-group">
            <select class="form-control" name="genres">
                <option>Genres de films :</option>
                <?php foreach ($listeGenres as $value) { ?>
                    <option value="<?= $value ?>"><?= $value ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <select class="form-control" name="year">
                <option>Année du films :</option>
                <?php foreach ($listeGenres as $value) { ?>
                    <option value="<?= $value ?>"><?= $value ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Titre du film" name="title">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Réalisateur" name="directors">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Acteur" name="cast">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Scenariste" name="writers">
        </div>
        <button type="submit" class="" name="userForm" value="userForm">Envoyer</button>
    </fieldset>
</form>