<?php
require_once 'config.php';
$requete = $connexion->prepare("SELECT * FROM calendriers");
$requete->execute();
$resultat = $requete->fetchAll();
?>

<h2 class="mb-4">Calendrier Scolaire — Année 2025-2026</h2>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Jour</th>
                <th>Date</th>
                <th>Évènement</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!$resultat): ?>
                <tr>
                    <td colspan="3">Aucun évènement trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($resultat as $ligne): ?>
                <tr>
                    <td><?= htmlspecialchars($ligne['jour']) ?></td>
                    <td><?= htmlspecialchars($ligne['dates']) ?></td>
                    <td><?= htmlspecialchars($ligne['evenement']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- BUG FIXÉ : suppression du <script src="./styles/bootstrap.bundle.min.js"> redondant -->
