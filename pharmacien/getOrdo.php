<?php
include '../protection.php';
header('Content-Type: application/json');

  if (isset($_POST['uuid']))
  {
    $req = $bdd->prepare("SELECT * FROM user WHERE uuidUser = :uuid");
    $req->execute(array(
      "uuid" => $_POST["uuid"]
    ));
    $idUser = $req->fetch()["idUser"];
    if (!is_null($idUser))
    {
      $req = $bdd->prepare("SELECT * FROM ordonance WHERE idUser = :idUser AND usetime > 0 ORDER BY dateCrea DESC LIMIT 0, 5");
      $req->execute(array(
        "idUser" => $idUser
      ));
      echo "[";
      $i = 0;
      $tmp = $req->fetchAll();
      foreach ($tmp as $donnees) {
        echo "{";
        $req = $bdd->prepare("SELECT * FROM user WHERE idUser = :idUser");
        $req->execute(array(
          "idUser" => $donnees["idMedecin"]
        ));
        $valMed = $req->fetch();
        echo "\"name\": \"" . $valMed["firstName"] . " " . $valMed["lastName"] . "\",";
        echo "\"id\": \"" . $donnees["idOrdonance"] . "\",";
        echo "\"date\": \"" . $donnees["dateCrea"] . "\"";
        $i++;
        echo "}";
        if ($i != count($tmp)) {
          echo ",";
        }
      }
      echo "]";
    }
  }
  else {
    echo "ko";
  }
?>
