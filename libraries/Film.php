<?php
class RQ
{
    public static function select($champ, $table, $order, $limite)
    {
        require_once "pdo.php";
        $rq = $pdo->query("SELECT $champ FROM $table $order $limite");
        return $rq;
    }
}
class Film
{
    public static function displayShortFilm($limite)
    {
        $rq = RQ::select('id_movie, title, year, genres, plot', 'movies_full', ' ORDER BY title', ' LIMIT ' . $limite . ',20');
        echo "<main class='index'>";
        while ($result = $rq->fetch(PDO::FETCH_ASSOC)) {
            $result['plot'] = substr($result['plot'], 0, 60) . '...';
            echo "
            <div class='card mb-3'>
                <h4 class='card-header'>" . $result['title'] . "</h4>
                <div class='card-body'>
                    <h5 class='card-title'>Genres : " . $result['genres'] . "</h5>
                    <h6 class='card-subtitle text-muted'>Film sorti en " . $result['year'] . "</h6>
                </div>
                <img style='height: 200px; width: 100%; display: block;' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22318%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_158bd1d28ef%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_158bd1d28ef%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22129.359375%22%20y%3D%2297.35%22%3EImage%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' alt='Card image'>
                <div class='card-body'>
                    <p class='card-text'>Résumé : " . $result['plot'] . "</p>
                </div>
                <div class='card-footer text-muted'>
                    <a href='movie.php?id=" . $result['id_movie'] . "'>Plus d'info...</a>
                </div>
            </div>";
        }
        echo "</main>";
    }

    public static function displayFilm($id)
    {
        $rq = RQ::select('id_movie, title, year, genres, plot,rating,popularity,directors,slug', 'movies_full WHERE id_movie=' . $id, '', '');
        echo "<main class='index'>";
        while ($result = $rq->fetch(PDO::FETCH_ASSOC)) {
            echo "
                <div>" . $result['title'] . "</div>
                <div>" . $result['year'] . "</div>
                <div>" . $result['genres'] . "</div>
                <div>" . $result['plot'] . "</div>
                <div>" . $result['rating'] . "</div>
                <div>" . $result['popularity'] . "</div>
                <div>" . $result['directors'] . "</div>
                <div>" . $result['slug'] . "</div>";
        }
    }
}
