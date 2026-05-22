<?php
/**
 * ScolarPay - Configuration de la Base de Données MySQL
 * C.S. Mont-Amba
 */

// Paramètres de connexion
$host = 'localhost';
$db   = 'gestion_paiement';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Configuration de la chaîne de connexion (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options PDO pour la sécurité et la gestion des erreurs
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // En production, ne pas afficher le message détaillé de l'erreur pour la sécurité.
     // Ici, nous affichons un JSON propre pour notre API.
     header('Content-Type: application/json; charset=utf-8');
     http_response_code(500);
     echo json_encode([
         "error" => "Erreur de connexion à la base de données MySQL",
         "details" => $e->getMessage()
     ]);
     exit;
}
?>
