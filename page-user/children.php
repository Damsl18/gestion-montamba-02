<?php
    require_once 'config.php';

    $requete = $connexion -> prepare ("SELECT * FROM eleves WHERE id_user = ?");
    $requete -> execute([$_SESSION['id_user']]);
    $resultat = $requete -> fetchAll();


?>
<h1 class="text-center mb-5"> Mes enfants</h1>
<div class="container my-5">
    <?php if(!$resultat): ?>
        <h2>Vous n'avez aucun enfants.</h2>
    <?php else: ?> 
        <div class="row g-4">
            <?php foreach($resultat as $ligne): ?>
                <div class="catalogue col-md-6 col-lg-4">
                    <div class="card h-100 ">
                        <div class="card-body g-4">
                            <div class="col-md-6 col-lg-12">
                                <h2><?= $ligne['id_eleve'] ?></h2>
                                <h2><?= $ligne['nom'] ?></h2>
                                <h2><?= $ligne['post_nom'] ?></h2>
                                <h2><?= $ligne['prenom'] ?></h2>
                                <p class="card-text">Classe: <?= $ligne['classe']?> </p>
                                <p class="card-text">Option: <?= $ligne['options']?> </p>
                                <p class="card-text">Catégorie <?= $ligne['categorie']?></p>
                                <p class="card-text fw-bold">Sexe : <?= $ligne['sexe']?></p>
                                <p class="card-text fw-bold">Statut : <?= $ligne['statut']?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
<script src="styles/bootstrap.bundle.min.js"></script>