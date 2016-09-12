<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=BEATMYDJ;charset=utf8', 'Administrateur', 'Etnagpe2017');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
function($bdd);
?>