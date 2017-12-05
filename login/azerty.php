<?php

require 'database.php';
    
$database = new Database("ordonum", "ordonum");
$pdo = $database->getPDO();
var_dump($pdo);

require 'Users.php';

$array = array(
    "firstName" => "Lisa",
    "lastName" => "jsp",
    "mail" => "jsss@epitech.eu",
    "passwd" => "1234",
    "type" => 0,
    "sexe" => 0,
);

$edit_array = array(
    "idUser" => 2,
    "lastName" => "Bruhwiler",
);

/*$users = new Users($pdo);
//$users->addUser($array);
//$users->editUser($edit_array);
//$users->delUser(2);
$users->getUserInfo(1);
var_dump($users);*/

require 'Ordonance.php';

$ordo_arr = array(
    "idMedecin" => "823",
    "idUser" => "123",
    "title" => "SIDA",
    "date" => "2017/05/18",
);

$edit_ordo = array(
    "idOrdonance" => "1",
    "idUser" => "12345",
);

/*$ordo = new Ordonance($pdo);
//$ordo->addOrdo($ordo_arr);
//$ordo->editOrdo($edit_ordo);
$cc = $ordo->getOrdoInfo(1);
var_dump($cc);*/

require 'ItemOrdonance.php';

$item_arr = array(
    "idMedicament" => "123",
    "frequencyNumber" => "3",
    "frequencyPeriod" => "par jour",
    "conditions" => "Avant de dormir",
    "dose" => "200 MG",
);

$edit_itemordo = array(
    "idItemOrdonance" => 1,
    "conditions" => "jamais",
);

/*$item = new ItemOrdonance($pdo);
//$item->addItemOrdo($item_arr);
$item->editItemOrdo($edit_itemordo);*/

require 'Allergie.php';
    
$allergie_arr = array(
    "idUser" => "123",
    "idMedicament" => "1234",
);

/*$allergie = new Allergie($pdo);
$allergie->addAllergie($allergie_arr);*/

require 'Message.php';

$mess = array(
    "idUser" => "123",
    "dateMsg" => "2019/1/23",
    "content" => "Salut",
    "toUser" => "234",
);

$message = new Message($pdo);
//$message->addMessage($mess);
$message->delMessage(3);
//$message->delAllMessage();

?>