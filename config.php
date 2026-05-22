<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "gestion_paiement";

$connexion = new PDO("mysql:host=$server; dbname=$db", $user, $password);