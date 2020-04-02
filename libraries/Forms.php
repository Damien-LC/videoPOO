<?php

/***************************************************************************************************************** */
/********INSCRIPTION************************ */
/***************************************************************************************************************** */

require_once "autoloader.php";


class Forms
{

    public static function displayInscription()
    {

        $erreur = '';

        // ********************************************************************
        // Insertion en Base
        // ********************************************************************


        if (!empty($_POST["inscription"]) && isset($_POST["inscription"])) {

            var_dump($_POST);

            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = htmlspecialchars($_POST['email']);
            $password1 = htmlspecialchars($_POST['password1']);
            $password2 = htmlspecialchars($_POST['password2']);


            if (empty($pseudo)) {
                $erreur = "le champ pseudo n'est pas rempli";
            }
            if (empty($password1)) {
                $erreur = "le champ mot de passe n'est pas rempli";
            }
            if (empty($password2)) {
                $erreur = "Vous devez confirmer votre mot de passe";
            }
            if (empty($email)) {
                $erreur = "le champ email n'est pas rempli";
            } else {
                //Verifier si l'email et deja enregistrer
                $selectMail = Model::select('email', 'users', '', '', 'WHERE email =?', [$email]);
                $result = $selectMail->rowCount();
                if ($result !== 0) {
                    $erreur = "Vous êtes déjà enregistré sur ce site.";
                }
            };
            // Verif email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreur = "l'adresse mail n'est pas valide";
            }
            //Compare les deux mots de passe
            if ($password1 !== $password2) {
                $erreur = "les 2 mots de pass ne sont pas identiques";
            }

            //hash mot de passe BDD
            $password = hash('sha256', $password1);

            if ($erreur === '') {
                // je determine si mon utilisateur a envoyé une image ou pas
                if ($_FILES['avatar']['size'] === 0) {
                    // si il ny a pas d'image $photo enregistré dans ma base sera vide
                    $url_avatar = '';
                } else {
                    // si il y a une image je redimenssionne la photo
                    $url_avatar = Img::imgResize(300, 'img/', $_FILES['avatar']);
                    $avatar = $_FILES['avatar']['name'];
                }
                // Envoie des données formulaire
                Model::insert("pseudo,email,password,avatar,reg_date", "users", "?,?,?,?,?", [$pseudo, $email, $password, $url_avatar, date("Y-m-d")]);
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['avatar'] = $url_avatar;
                header("Location: index.php");
            } else {
                echo $erreur;
            }
        }
    }


    /***************************************************************************************************************** */
    /********CONNEXION************************ */
    /***************************************************************************************************************** */


    public static function displayConnexion()
    {
        $dataConnect = "";
        if (isset($_POST['formConnect']) && !empty($_POST['formConnect'])) {
            $dataConnect = $_POST;
        }
        if ($dataConnect !== "") {
            $erreur = "";
            if (!empty($dataConnect['email']) && !empty($dataConnect['password'])) {
                $email = $dataConnect['email'];
                $password = hash('sha256', $dataConnect['password']);
                $rq = Model::select('*', 'users', '', '', " WHERE email=? AND password=?", [$email, $password]);
                $active = $rq->rowCount();
            } else {
                $erreur .= "<div>Une erreur s'est produite lors de votre saisie.</div>";
            }
            if ($active !== 0) {
                // reussite -> enregister dans $_SESSION les données de l'utilisateur
                $result = $rq->fetch(PDO::FETCH_ASSOC);
                $_SESSION['pseudo'] = $result['pseudo'];
                $_SESSION['avatar'] = $result['avatar'];
                header("Location: index.php");
            } else {
                $erreur .= "<div>Une erreur s'est produite lors de votre saisie.</div>";
            }
            echo $erreur;
        }
    }
    public static function displayUser()
    {
        // recuperation de genres
        $rq = Model::select('genres', 'movies_full', '', '', '', '');
        $listeGenres = [];
        while ($result = $rq->fetch(PDO::FETCH_ASSOC)) {
            $genreTmp = array_map('trim', explode(',', $result['genres']));
            $listeGenres = array_merge($genreTmp, $listeGenres);
        }
        $listeGenres = array_unique($listeGenres);
        sort($listeGenres);
        echo "<select name='genres'>";
        foreach ($listeGenres as $value) {
            echo "<option value='$value'>$value</option>";
        }
        echo "</select>";
        // recuperation des tiles
        echo "<form method='POST' action='user_pref.php'>
    <input type='text' name='title'>
    <input type='submit'></form>";
        if (isset($_POST['title']) && !empty($_POST['title'])) {
            $titre = "%" . $_POST['title'] . "%"; //je concatene mes % ici et pas dans ma requete.
            $rq = Model::select('title', 'movies_full', '', '', 'WHERE title LIKE ?', [$titre]);
            while ($result = $rq->fetch(PDO::FETCH_ASSOC)) {
                echo $result['title'];
            }
        }
    }
}
