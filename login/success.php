<?php
include '../db.php';
session_start();
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
        <p class="message information">
          Félictation votre compte a correctement été crée
        </p>
        <p class="message">
          <a href="/login">Connexion</a>
        </p>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
