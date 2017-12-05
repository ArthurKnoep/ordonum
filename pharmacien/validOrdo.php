<?php
include '../protection.php';
if (!isset($_GET["id"]))
{
  header('Location:/');
}
if ($_SESSION['typeUser'] == 1) {
  header('Location:/');
}
$req = $bdd->prepare('UPDATE ordonance SET usetime = usetime - 1 WHERE idOrdonance = :idOrdonance');
$req->execute(array(
  'idOrdonance' => $_GET['id']
));
header('Location:/pharmacien/success');
?>
