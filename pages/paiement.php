<?php
require_once 'config.php';

$request = $connexion->prepare("SELECT * FROM paiements");
$request->execute();
$resultat = $request->fetchAll();
?>

<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="h4 mb-0">Gestion des paiements</h1>
</div>

<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Catégorie</th>
                <th>Motif</th>
                <th>Montant</th>
                <th>Mode de paiement</th>
                <th>Utilisateur</th>
                <th>Élève concerné</th>
                <th>Évènement</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultat as $ligne): ?>
            <tr>
                <td><?= $ligne['id_paiement'] ?></td>
                <td><?= htmlspecialchars($ligne['categorie']) ?></td>
                <td><?= htmlspecialchars($ligne['motif']) ?></td>
                <td><?= htmlspecialchars($ligne['montant']) ?></td>
                <td><?= htmlspecialchars($ligne['mode_paiement']) ?></td>
                <td><?= htmlspecialchars($ligne['id_user']) ?></td>
                <td><?= htmlspecialchars($ligne['id_eleve']) ?></td>
                <td><?= htmlspecialchars($ligne['id_evenement']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>