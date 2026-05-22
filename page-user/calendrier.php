<?php
require_once 'config.php';
$requete = $connexion->prepare("SELECT * FROM calendriers");
$requete->execute();
$resultat = $requete->fetchAll();
?>
<h1>Voici le Calendrier Scolaire pour l'année 2025-2026</h1>
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
                    <td colspan="4">Aucun évènement trouvé.</td>
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
<script src="./styles/bootstrap.bundle.min.js"></script>