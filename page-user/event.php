<?php
    require_once 'config.php';

    $requete = $connexion -> prepare("SELECT * FROM evenements");
    $requete -> execute();
    $resultat = $requete -> fetchAll();
?>

<h2 class="mb-4">Catalogue des excursions</h2>

<div class="container px-0">
    <?php if(!$resultat): ?>
        <div class="alert alert-info">Aucun événement trouvé.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($resultat as $ligne): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <?php if(!empty($ligne['photo'])): ?>
                        <img src="image/<?= htmlspecialchars($ligne['photo']) ?>" style="object-fit:cover;border-radius:4px;"
                             alt="Image de l'excursion"
                             class="card-img-top"
                             style="height:180px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($ligne['description']) ?></h5>
                            <p class="card-text text-muted small mb-1">
                                <i class="bi bi-people me-1"></i>Classe : <?= htmlspecialchars($ligne['classe_concernee']) ?>
                            </p>
                            <p class="card-text fw-bold mt-auto mb-3">
                                <i class="bi bi-cash me-1 text-success"></i>
                                Prix total :
                                <?= htmlspecialchars($ligne['frais_entree'] + $ligne['frais_transport'] + $ligne['frais_encadrement']) ?> $
                            </p>
                            <a href="?page=paiement" class="btn btn-success w-100 mt-auto">
                                <i class="bi bi-credit-card me-1"></i>Payer cette excursion
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<!-- BUG FIXÉ : suppression du <script src="styles/bootstrap.bundle.min.js"> redondant -->
