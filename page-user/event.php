<?php
    require_once 'config.php';

    $requete = $connexion -> prepare ("SELECT * FROM evenements");
    $requete -> execute();
    $resultat = $requete -> fetchAll();

?>
<h1 class="text-center mb-5"> Catalogue des excursion</h1>
<div class="container my-5">
    <?php if(!$resultat): ?>
        <h2>Aucun évènement trouvé.</h2>
    <?php else: ?> 
        <div class="row g-4">
            <?php foreach($resultat as $ligne): ?>
                <div class="catalogue col-md-6 col-lg-4">
                    <div class="card h-100 ">
                        <div class="card-body g-4">
                            <div class="col-md-6 col-lg-12">
                                <img src="image/<?= htmlspecialchars($ligne['photo']) ?>" alt="image du lieu" class="img-fluid rounded-2 mb-2">
                                <h2><?= $ligne['description'] ?></h2>
                                <p class="card-text">Classe concernée <?= $ligne['classe_concernee']?> </p>
                                <p class="card-text fw-bold">Prix : <?= $ligne['frais_entree'] + $ligne['frais_transport'] + $ligne['frais_encadrement'] ?>$</p>
                                <a href="?page=paiement" class="btn btn-success w-100 ">Payer cette excursion</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
<script src="styles/bootstrap.bundle.min.js"></script>