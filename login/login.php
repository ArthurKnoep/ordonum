<?php
include '../db.php';
session_start();
function chaine_aleatoire($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789')
{
    $nb_lettres = strlen($chaine) - 1;
    $generation = '';
    for($i=0; $i < $nb_car; $i++)
    {
        $pos = mt_rand(0, $nb_lettres);
        $car = $chaine[$pos];
        $generation .= $car;
    }
    return $generation;
}

if (isset($_SESSION['idUser']) && $_SESSION['idUser'] != -1)
{
  header('Location:/');
}
if (isset($_POST['login']))
{
  $req = $bdd->prepare("SELECT * FROM user WHERE mail = :mail AND passwd = :passwd");
  $req->execute(array(
    'mail' => $_POST['mail'],
    'passwd' => sha1($_POST['passwd'])
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
    $_SESSION['sexeUser'] = $donnee['sexe'];
    header('Location:/');
  }
  else {
    header('Location:/login?failed');
  }
}
if (isset($_POST['register']))
{
  $erreur = 0;
  $req = $bdd->prepare("SELECT * FROM user WHERE mail = :mail");
  $req->execute(array(
    "mail" => $_POST["mail"]
  ));
  while ($donnee = $req->fetch())
  {
    if ($donnee['mail'] == $_POST['mail'])
    {
      $erreur = 1;
    }
  }
  $uuid;
  do {
    $stop = 0;
    $uuid = chaine_aleatoire(16);
    $req = $bdd->prepare("SELECT * FROM user WHERE uuidUser = :uuid");
    $req->execute(array(
      "uuid" => $uuid
    ));
    $stop = 1;
    while ($donnee = $req->fetch())
    {
      if ($donnee['uuidUser'] == $uuid)
      {
        $stop = 0;
      }
    }
  } while ($stop == 0);
  if ($erreur == 0)
  {
    $req = $bdd->prepare("INSERT INTO user(firstName, lastName, mail, passwd, uuidUser, type, sexe, dateBirth) VALUES (:firstName, :lastName, :mail, :passwd, :uuidUser, :type, :sexe, :dateBirth)");
    $req->execute(array(
      "firstName" => $_POST['firstName'],
      "lastName" => $_POST['lastName'],
      "mail" => $_POST['mail'],
      "passwd" => sha1($_POST['passwd']),
      "uuidUser" => $uuid,
      "type" => 1,
      "sexe" => $_POST['sexe'],
      "dateBirth" => $_POST['dateBirth']
    ));
    header('Location:/login/success');
  }
  else {
    header('Location:/login/failed');
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <meta name="viewport" content="width=device-width">
  </head>
  <body>
    <div class="login-page">
      <div class="form">
        <img class="main-logo" src="img/ordonum.png" />
        <form action="login.php" method="post" class="register-form">
          <input type="hidden" name="register" value=""/>
          <input required type="text" name="firstName" placeholder="Prénom"/>
          <input required type="text" name="lastName" placeholder="Nom"/>
          <input required type="email" name="mail" placeholder="Adresse Mail"/>
          <input required type="password" name="passwd" placeholder="Mot de passe"/>
          <select required name="sexe">
            <option value="1">Homme</option>
            <option value="0">Femme</option>
          </select>
          <input required type="date" name="dateBirth" placeholder="Date de naissance (JJ/MM/AAAA)"/>
          <button>créer</button>
          <p class="message">Déja enregisté? <a href="#">Connexion</a></p>
        </form>
        <form action="login.php" method="post" class="login-form">
          <input type="hidden" name="login" value=""/>
          <input type="email" <?php if (isset($_GET['failed'])) { echo 'style="border: tomato 2px solid;"'; } ?> required name="mail" placeholder="Adresse Mail" />
          <input type="password" <?php if (isset($_GET['failed'])) { echo 'style="border: tomato 2px solid;"'; } ?> required name="passwd" placeholder="Mot de passe"/>
          <input type="submit" value="connexion"/>
          <p class="message">Pas de compte? <a href="#">Créer un compte</a></p>
        </form>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
