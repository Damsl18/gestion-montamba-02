<?php
/**
 * ScolarPay - API Enregistrement d'un Paiement
 * Met à jour le solde d'un élève après réception du montant versé
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/config.php';

// Récupérer le corps de la requête (JSON envoyé par Javascript Fetch)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Extraction des paramètres
$childId = isset($input['id_eleve']) ? intval($input['id_eleve']) : null;
$amount = isset($input['montant']) ? floatval($input['montant']) : null;

if (!$childId || $amount <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Données d'entrée invalides (id_eleve et montant requis)"]);
    exit;
}

try {
    // 1. Récupérer l'état actuel de l'élève
    $stmt = $pdo->prepare('SELECT statut FROM eleves WHERE id_eleve = ?');
    $stmt->execute([$childId]);
    $child = $stmt->fetch();

    if (!$child) {
        http_response_code(404);
        echo json_encode(["error" => "Élève non trouvé"]);
        exit;
    }

    // 2. Calculer le nouveau montant payé
    $newPaid = floatval($child['frais_paye']) + $amount;
    
    // Déterminer le nouveau statut
    $newStatus = ($newPaid >= floatval($child['frais_total'])) ? 'Paye' : 'Tranche 1';

    // 3. Mettre à jour la base de données
    $updateStmt = $pdo->prepare('UPDATE eleves SET frais_paye = ?, statut = ? WHERE id_eleve = ?');
    $updateStmt->execute([$newPaid, $newStatus, $childId]);

    echo json_encode([
        "success" => true,
        "message" => "Paiement enregistré avec succès",
        "newStatus" => $newStatus,
        "newPaidFees" => $newPaid
    ]);

} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Erreur lors du traitement du paiement",
        "details" => $e->getMessage()
    ]);
}
?>
