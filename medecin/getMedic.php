<?php
include '../protection.php';
if ($_SESSION['typeUser'] != 2) {
  header('Location:/');
}
header('Content-Type: application/json');
$req = $bdd->query("SELECT * FROM medicament");
echo json_encode($req->fetchAll());
?>
