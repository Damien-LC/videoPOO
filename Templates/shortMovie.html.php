<main class="index">
    <?php foreach ($shortFilmResult as $reslut) {
        $result['plot'] = substr($result['plot'], 0, 60) . '...'; ?>
        <div class="card mb-3">
            <h4 class="card-header"><?= $result['genres'] ?></h4>
            <div class="card-body">
                <h5 class="card-title">Genres : <?= $result['genres'] ?></h5>
                <h6 class="card-subtitle text-muted">Film sorti en <?= $result['year'] ?></h6>
            </div>
            <img style="height: 200px; width: 100%; display: block;" src="data:image/svg+xml">
            <div class="card-body">
                <p class="card-text">Résumé : <?= $result['plot'] ?></p>
            </div>
            <div class="card-footer text-muted">
                <a href="movie.php?id=<?= $result['id_movie'] ?>">Plus d'info ...</a>
            </div>
        </div>
    <?php } ?>
</main>