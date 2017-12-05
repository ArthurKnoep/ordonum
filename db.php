<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=ordonum;charset=utf8', 'root', '1234');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>
