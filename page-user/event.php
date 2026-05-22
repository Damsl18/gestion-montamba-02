<?php
    require_once 'config.php';

    $requete = $connexion -> prepare ("SELECT * FROM evenements");
    $requete -> execute();
    $resultat = $requete -> fetchAll();


?>
<section class="catalogue">
    <div class="container my-5">
        <h1 class="text-center mb-5"> Catalogue des excursion</h1>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                    <?php if(!$resultat): ?>
                        <h2>Aucun évènement trouvé.</h2>
                    <?php else: ?>
                        <?php foreach($resultat as $ligne): ?>
                            <div class="catenue-title">
                                <h2><?= $ligne['description'] ?></h2>
                                <p class="card-text">Classe concernée <?= $ligne['classe_concernee']?> </p>
                                <p class="card-text fw-bold">Prix : <?= $ligne['frais_entree'] + $ligne['frais_transport'] + $ligne['frais_encadrement'] ?>$</p>
                        <a href="paiement.php" class="btn btn-success w-100 ">Payer cette excursion</a>
                        <?php endforeach ?>
                    <?php endif ?>
            </div>
        </div>
    </div>
</section>
<script src="styles/bootstrap.bundle.min.js"></script>