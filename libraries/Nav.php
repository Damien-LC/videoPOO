<?php
class Nav
{
  public static function displayNav()
  {
    session_start();

    if (isset($_GET['deco']) && $_GET['deco']) {
      $_SESSION = [];
      session_unset();
      session_destroy();
    }

    if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo'])) {
      echo "Bonjour " . $_SESSION["pseudo"];
      if ($_SESSION["avatar"] !== "") {
        echo "<img src='" . $_SESSION['avatar'] . "'>";
      }
    }
  }
}
