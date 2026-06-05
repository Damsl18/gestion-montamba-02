
<h2 class="mb-4">Comment payer ?</h2>

<section class="part1 mb-4 card shadow-sm p-4">
    <h3 class="h5 mb-3">Étape 1 : Accédez au portail de paiement</h3>
    <p>Allez dans le menu <strong>Paiement</strong> ou cliquez directement ici :</p>
    <!-- BUG FIXÉ : lien "./paiement.php" non valide dans le contexte de home.php (include) →
         remplacé par le lien relatif à la page courante -->
    <a href="?page=paiement" class="btn btn-sm btn-outline-primary">Accéder au paiement</a>
</section>

<section class="part1 mb-4 card shadow-sm p-4">
    <h3 class="h5 mb-3">Étape 2 : Insérez l'identifiant de l'élève et sa catégorie</h3>
    <p>L'identifiant de l'élève est fourni lors de l'inscription. Trois catégories sont disponibles :</p>
    <!-- BUG FIXÉ : lien "./index.php" pointait vers la page de login →
         remplacé par ?page=acceuil -->
    <p>Pour voir les modalités de chaque catégorie, consultez la <a href="?page=acceuil">page d'accueil</a>.</p>
    <div class="row">
        <div class="col-12 col-md-8">
            <ul class="mb-0">
                <li>Payer les frais scolaires</li>
                <li>Payer pour les activités et sorties scolaires</li>
                <li>Payer les uniformes et fournitures scolaires</li>
                <li>Cantine</li>
            </ul>
        </div>
    </div>
</section>

<section class="part1 mb-4 card shadow-sm p-4">
    <h3 class="h5 mb-3">Étape 3 : Mentionnez le motif du paiement</h3>
    <div class="row">
        <div class="col-12 col-md-8">
            <ul class="mb-0">
                <li>Frais scolaires</li>
                <li>Activités et sorties scolaires</li>
                <li>Uniformes et fournitures scolaires</li>
                <li>Cantine</li>
            </ul>
        </div>
    </div>
</section>

<section class="part1 mb-4 card shadow-sm p-4">
    <h3 class="h5 mb-3">Étape 4 : Choisissez votre mode de paiement</h3>
    <div class="row">
        <div class="col-12 col-md-8">
            <ul class="mb-0">
                <li><strong>Mobile Money :</strong> payer par téléphone (Airtel Money, M-Pesa, etc.) via votre numéro mobile.</li>
                <li><strong>Virement Bancaire :</strong> effectuez le transfert depuis la banque recommandée.</li>
                <li><strong>Paiement en Espèces :</strong> rendez-vous au bureau de la comptabilité.</li>
            </ul>
        </div>
    </div>
</section>

<section class="part1 mb-4 card shadow-sm p-4">
    <h3 class="h5 mb-3">Étape 5 : Confirmation</h3>
    <p>Vérifiez les informations et validez le paiement. Un reçu ou message de confirmation vous sera envoyé.</p>
</section>

<a href="?page=paiement" class="btn btn-success">Effectuer un paiement</a>

<!-- BUG FIXÉ : suppression du <script src="./styles/bootstrap.bundle.min.js"> redondant -->
