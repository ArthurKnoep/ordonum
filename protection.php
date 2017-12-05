<?php
include 'db.php';
session_start();
if (!isset($_SESSION['idUser']) && $_SESSION['idUser'] != -1)
{
  header('Location:/login');
}
else {
  $req = $bdd->prepare("SELECT * FROM user WHERE idUser = :idUser");
  $req->execute(array(
    'idUser' => $_SESSION['idUser']
  ));
  $donnee = $req->fetch();
  if ($donnee["idUser"])
  {
    $_SESSION['idUser'] = $donnee['idUser'];
    $_SESSION['firstName'] = $donnee['firstName'];
    $_SESSION['lastName'] = $donnee['lastName'];
    $_SESSION['mail'] = $donnee['mail'];
    $_SESSION['uuidUser'] = $donnee['uuidUser'];
    $_SESSION['typeUser'] = $donnee['type'];
    $_SESSION['dateBirth'] = $donnee['dateBirth'];
    $_SESSION['sexeUser'] = $donnee['sexe'];
  }
  else {
    header('Location:/login');
  }
}
?>
