<?php
include '../protection.php';
if (isset($_POST["count"]))
{
  $req = $bdd->prepare("SELECT * FROM user WHERE uuidUser = :uuid");
  $req->execute(array(
    "uuid" => $_POST["uuid"]
  ));
  $idUser = $req->fetch()["idUser"];
  if (!is_null($idUser))
  {
    $req = $bdd->prepare("INSERT INTO ordonance(idMedecin, idUser, dateCrea, endDate, useTime) VALUES(:idMed, :idUser, NOW(), ADDDATE(NOW(), 60), :useTime)");
    $req->execute(array(
      "idMed" => $_SESSION['idUser'],
      "idUser" => $idUser,
      "useTime" => $_POST["reuse"]
    ));
    $req = $bdd->query("SELECT * FROM ordonance ORDER BY idOrdonance DESC");
    $idOrdo = $req->fetch()["idOrdonance"];
    $i = 0;
    while ($i < $_POST["count"])
    {
      $req = $bdd->prepare("INSERT INTO itemOrdonance(idMedicament, frequency, period, dose, idOrdonance) VALUES (:idMedic, :frequency, :period, :dose, :idOrdo)");
      $req->execute(array(
        "idMedic" => $_POST[strval($i) . "name"],
        "frequency" => $_POST[strval($i) . "number"],
        "period" => $_POST[strval($i) . "period"],
        "dose" => $_POST[strval($i) . "dose"],
        "idOrdo" => $idOrdo
      ));
      $i++;
    }
    header('Location:/');
  }
  else {
    header('Location:/medecin/ordonance.php');
  }
}
?>
