<?php
    require_once 'config.php';

    $requete = $connexion -> prepare ("SELECT * FROM evenements");
    $requete -> execute();
    $resultat = $requete -> fetchAll();


?>
<h1 class="text-center mb-5"> Catalogue des excursion</h1>
<div class="">
    <?php if(!$resultat): ?>
    <h2>Aucun évènement trouvé.</h2>
    <?php else: ?> 
    <?php foreach($resultat as $ligne): ?>
    <section class="catalogue">
    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                            <div class="catenue-title">
                                <h2><?= $ligne['description'] ?></h2>
                                <p class="card-text">Classe concernée <?= $ligne['classe_concernee']?> </p>
                                <p class="card-text fw-bold">Prix : <?= $ligne['frais_entree'] + $ligne['frais_transport'] + $ligne['frais_encadrement'] ?>$</p>
                        <a href="paiement.php" class="btn btn-success w-100 ">Payer cette excursion</a>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach ?>
    <?php endif ?>
</div>
<script src="styles/bootstrap.bundle.min.js"></script>