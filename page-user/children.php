<?php
    require_once 'config.php';

    $requete = $connexion -> prepare("SELECT * FROM eleves WHERE id_user = ?");
    $requete -> execute([$_SESSION['id_user']]);
    $resultat = $requete -> fetchAll();
?>

<h2 class="mb-4">Mes enfants</h2>

<div class="container px-0">
    <?php if(!$resultat): ?>
        <div class="alert alert-info">Vous n'avez aucun enfant enregistré.</div>
    <?php else: ?>
        <!-- BUG FIXÉ : row g-4 correct, mais les classes col-md-6 col-lg-12 imbriquées
             à l'intérieur de card-body étaient redondantes et cassaient la mise en page -->
        <div class="row g-4">
            <?php foreach($resultat as $ligne): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <?= htmlspecialchars($ligne['nom']) ?>
                                <?= htmlspecialchars($ligne['post_nom']) ?>
                                <?= htmlspecialchars($ligne['prenom']) ?>
                            </h5>
                            <ul class="list-unstyled mb-0 small">
                                <li><span class="fw-semibold">ID :</span> <?= htmlspecialchars($ligne['id_eleve']) ?></li>
                                <li><span class="fw-semibold">Classe :</span> <?= htmlspecialchars($ligne['classe']) ?></li>
                                <li><span class="fw-semibold">Option :</span> <?= htmlspecialchars($ligne['options']) ?></li>
                                <li><span class="fw-semibold">Catégorie :</span> <?= htmlspecialchars($ligne['categorie']) ?></li>
                                <li><span class="fw-semibold">Sexe :</span> <?= htmlspecialchars($ligne['sexe']) ?></li>
                                <li>
                                    <span class="fw-semibold">Statut :</span>
                                    <?= htmlspecialchars($ligne['statut']) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<!-- BUG FIXÉ : suppression du <script src="styles/bootstrap.bundle.min.js"> redondant
     Bootstrap est déjà chargé dans home.php -->
