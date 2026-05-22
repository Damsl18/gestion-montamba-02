<?php
/**
 * ScolarPay - API Récupération des élèves (Mes Enfants)
 * Retourne la liste des enfants au format JSON pour un parent (ID = 1 simulé)
 */

// Permettre les requêtes cross-origin si nécessaire et définir le type de contenu
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/config.php';

try {
    // Dans une version complète, vous récupéreriez l'ID du parent connecté via la session PHP ($_SESSION['parent_id'])
    $id_user = 1;

    // Requête préparée pour éviter toute injection SQL
    $stmt = $pdo->prepare('SELECT id_eleve, nom, post_nom, prenom, classe, id_user, frais_paye, frais_total, statut FROM eleves WHERE id_user = ?');
    $stmt->execute([$id_user]);
    
    $eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les résultats au format JSON
    echo json_encode($eleves, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Erreur lors de la récupération des données",
        "details" => $e->getMessage()
    ]);
}
?>
