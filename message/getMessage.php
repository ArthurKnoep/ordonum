<?php
include '../protection.php';
header('Content-Type: application/json');
/*
** Récup des personnes en comunication
*/
$listPers = array();
$req = $bdd->prepare("SELECT * FROM message WHERE idUser = :idUser OR toUser = :idUser ORDER BY dateMsg DESC");
$req->execute(array(
  "idUser" => $_SESSION['idUser']
));
while ($donnes = $req->fetch())
{
  if (!in_array($donnes["idUser"], $listPers) && $donnes["idUser"] != $_SESSION["idUser"])
  {
    array_push($listPers, $donnes["idUser"]);
  }
  if (!in_array($donnes["toUser"], $listPers) && $donnes["toUser"] != $_SESSION["idUser"])
  {
    array_push($listPers, $donnes["toUser"]);
  }
}

/*
** Recup des messages
*/
function rount_to($nombre, $arrondi) {
    return round($nombre / $arrondi) * $arrondi;
}

$mois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
echo "[";
$i = 0;
while ($i < count($listPers))
{
  echo "{";
    $req = $bdd->prepare("SELECT * FROM user WHERE idUser = :idUser");
    $req->execute(array(
      "idUser" => $listPers[$i]
    ));
    $donnes = $req->fetch();
    echo "\"name\": \"" . $donnes["firstName"] . " " . $donnes["lastName"] . "\",";
    echo "\"id\": " . $listPers[$i] . ",";
    echo "\"message\": [";
    $req = $bdd->prepare("SELECT * FROM message WHERE (idUser = :idUser AND toUser = :toUser) OR (idUser = :toUser AND toUser = :idUser) ORDER BY dateMsg");
    $req->execute(array(
      "idUser" => $_SESSION['idUser'],
      'toUser' => $listPers[$i]
    ));
    $tmp = $req->fetchAll();
    $j = 0;
    foreach ($tmp as $donnes)
    {
      echo "{";
      if ($donnes["idUser"] == $_SESSION["idUser"]) {
        echo "\"type\": 1,";
      }
      else {
        echo "\"type\": 0,";
      }
      echo "\"date\": \"";
      $now = date_create();
      $date = date_create($donnes['dateMsg']);
      $diff = date_diff($date, $now);
      if ($diff->format("%Y") >= 1)
      {
        echo "Le ".$date->format("d")." ".$mois[$date->format("n")-1]." ".$date->format("Y")." à ".$date->format("H")."h".$date->format("i");
      }

      if ($diff->format("%m") >= 1 && $diff->format("%Y") == 0)
      {
        echo "Le ".$date->format("d")." ".$mois[$date->format("n")-1]." à ".$date->format("H")."h".$date->format("i");
      }

      if ($diff->format("%d") >= 1 && $diff->format("%m") == 0 && $diff->format("%Y") == 0)
      {
        echo "Il y a ";
        if ($diff->format("%d") >= 2)
        {
          echo $diff->format("%d")." jours";
        }
        else {
          echo $diff->format("%d")." jour";
        }
        echo " à ".$date->format("H")."h".$date->format("i");
      }

      if ($diff->format("%H") >= 1 && $diff->format("%d") == 0 && $diff->format("%m") == 0 && $diff->format("%Y") == 0)
      {
        echo "Il y a ".$diff->format("%h")." h et ".$diff->format("%i")." min";
      }

      if ($diff->format("%i") >= 1 && $diff->format("%H") == 0 && $diff->format("%d") == 0 && $diff->format("%m") == 0 && $diff->format("%Y") == 0)
      {
        echo "Il y a ".$diff->format("%i")." min";
      }

      if ($diff->format("%s") >= 1 && $diff->format("%i") == 0 && $diff->format("%H") == 0 && $diff->format("%d") == 0 && $diff->format("%m") == 0 && $diff->format("%Y") == 0) {
        $nbSec = rount_to($diff->format("%s"),5);
        if ($nbSec > 0)
        {
          echo "Il y a ".$nbSec." sec";
        }
        else {
          echo "A l'instant";
        }
      }
      echo "\",";
      $contentText = $donnes['content'];
      $contentText = nl2br($contentText);
      $contentText = str_replace(CHR(13).CHR(10), '<br />', $contentText);
      $contentText = str_replace(CHR(13), '<br />', $contentText);
      $contentText = str_replace(CHR(10), '<br />', $contentText);
      $contentText = str_replace("\\", "\\\\", $contentText);
      $contentText = str_replace("\"", "\\\"", $contentText);
      echo "\"msg\": \"" . $contentText . "\"";
      echo "}";
      $j++;
      if ($j != count($tmp)) {
        echo ",";
      }
    }
  echo "]}";
  $i++;
  if ($i != count($listPers)) {
    echo ",";
  }
}
echo "]";
?>
