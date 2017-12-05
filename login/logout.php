<?php
  include '../protection.php';
  $_SESSION['idUser'] = -1;
  $_SESSION['firstName'] = "";
  $_SESSION['lastName'] = "";
  $_SESSION['mail'] = "";
  $_SESSION['uuidUser'] = "";
  $_SESSION['typeUser'] = "";
  $_SESSION['sexeUser'] = "";
  session_destroy();
  header('Location:/login');
?>
