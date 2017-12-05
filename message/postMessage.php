<?php
include '../protection.php';
if (isset($_POST['id']) and isset($_POST['msg']))
{
  $req = $bdd->prepare("INSERT INTO message (idUser, dateMsg, content, toUser) VALUES (:idUser, NOW(), :content, :to)");
  $req->execute(array(
    "idUser" => $_SESSION['idUser'],
    "content" => $_POST['msg'],
    "to" => $_POST['id']
  ));
  echo "ok";
}
else {
  echo "ko";
}
?>
