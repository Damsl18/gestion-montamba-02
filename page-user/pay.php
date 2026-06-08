<?php
    require_once 'config.php';
    $requete = $connexion -> prepare("SELECT * FROM evenements");
    $requete -> execute();
    $evenements = $requete -> fetchAll();
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valider'])){
        $stmt = $connexion->prepare("INSERT INTO paiements (categorie, motif, montant, mode_paiement, id_user, id_eleve, id_evenement) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $actu = $connexion -> prepare("UPDATE eleves SET statut = ? WHERE id_eleve =?");
        $req = $connexion->prepare("SELECT description FROM evenements WHERE id_evenement = ?");
        if(!($_POST['reason'] === 'autre' || empty($_POST['other_reason']))){
            $req->execute([$_POST['reason']]);
            $res = $req->fetch();
        }
        $motif = $_POST['reason'] === 'autre' ? $_POST['other_reason'] : ($res['description'] ?? '');
        $stmt->execute([
            htmlspecialchars($_POST['categorie']),
            $motif,
            htmlspecialchars($_POST['montant']),
            htmlspecialchars($_POST['paymentMethod']),
            htmlspecialchars($_SESSION['id_user']),
            htmlspecialchars($_POST['id_eleve']),
            $_POST['reason'] !== 'autre' ? htmlspecialchars($_POST['reason']) : null
        ]);
        $actu -> execute([
            "Payé",
            htmlspecialchars($_POST['id_eleve'])
        ]);
        echo "<script>alert('Paiement enregistré avec succès !');</script>";
    }
    //actualisation du statut 'payé' ou 'non payé' d'un élève après payement

?>

<div class="container px-0 py-2">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- En-tête -->
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle p-3 mb-3">
                    <i class="bi bi-cash-stack text-white fs-2"></i>
                </div>
                <h2 class="fw-bold text-primary">Paiement Scolaire</h2>
            </div>
            <div class="card shadow border-0">
                <div class="card-body p-3 p-md-5">
                    <form action="" method="POST">

                        <!-- Section identification élève -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-person-circle text-primary me-2"></i>
                                Identification de l'Élève
                            </h5>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="studentId" class="form-label fw-semibold">
                                        <i class="bi bi-key me-1"></i>Identifiant de l'élève
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </span>
                                        <?php
                                            $r = $connexion -> prepare("SELECT id_eleve, nom, post_nom FROM eleves WHERE id_user = ?");
                                            $r -> execute ([
                                                $_SESSION['id_user']
                                            ]);
                                            $enfants = $r -> fetchAll();
                                        ?>
                                        <select class="form-select" id="id" name="id_eleve" required>
                                            <?php foreach($enfants as $enfant): ?>
                                                <option value="<?= htmlspecialchars($enfant['id_eleve']) ?>"><?= htmlspecialchars($enfant['nom']) ?> - <?= htmlspecialchars($enfant['post_nom']) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="categorie" class="form-label fw-semibold">Catégorie</label>
                                    <select class="form-select" id="categorie" name="categorie" required>
                                        <option value="" selected disabled>Sélectionnez...</option>
                                        <option value="Extérieur">Extérieur</option>
                                        <option value="Autres">Autres</option>
                                        <option value="ORPUK">ORPUK</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section détails paiement -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-wallet2 text-primary me-2"></i>
                                Détails du Paiement
                            </h5>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label for="amount" class="form-label fw-semibold">Montant</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-currency-dollar text-success"></i>
                                        </span>
                                        <input type="number"
                                               class="form-control"
                                               id="amount"
                                               placeholder="0.00"
                                               min="1"
                                               step="0.01"
                                               name="montant"
                                               required>
                                        <span class="input-group-text bg-light fw-bold">USD</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="reason" class="form-label fw-semibold">Motif du paiement</label>
                                    <select class="form-select" id="reason" name="reason" required>
                                        <?php foreach($evenements as $evenement): ?>
                                            <option value="<?= htmlspecialchars($evenement['id_evenement']) ?>">
                                                <?= htmlspecialchars($evenement['description']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <option value="autre">Autre motif</option>
                                    </select>
                                    <div id="otherReasonGroup" style="display:none;" class="mt-2">
                                        <label for="otherReason" class="form-label fw-semibold">Précisez le motif</label>
                                        <input type="text"
                                               class="form-control"
                                               id="otherReason"
                                               name="other_reason"
                                               placeholder="Entrez le motif du paiement">
                                    </div>
                                </div>
                            </div>

                            <!-- Mode de paiement -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold d-block mb-3">
                                    <i class="bi bi-credit-card text-primary me-1"></i>
                                    Mode de paiement
                                </label>
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <div class="card border h-100">
                                            <div class="card-body text-center p-3">
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="radio"
                                                           name="paymentMethod"
                                                           id="mobilePayment"
                                                           value="Mobile money"
                                                           required>
                                                    <label class="form-check-label fw-semibold stretched-link" for="mobilePayment">
                                                        <div class="mb-2"><i class="bi bi-phone-fill fs-2 text-primary"></i></div>
                                                        Paiement Mobile
                                                    </label>
                                                </div>
                                                <p class="text-muted small mt-2 mb-0">Orange Money, M-Pesa, etc.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="card border h-100">
                                            <div class="card-body text-center p-3">
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="radio"
                                                           name="paymentMethod"
                                                           id="bankTransfer"
                                                           value="Virement bancaire">
                                                    <label class="form-check-label fw-semibold stretched-link" for="bankTransfer">
                                                        <div class="mb-2"><i class="bi bi-bank2 fs-2 text-primary"></i></div>
                                                        Virement Bancaire
                                                    </label>
                                                </div>
                                                <p class="text-muted small mt-2 mb-0">Transfert direct</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Détails Mobile Money -->
                            <div class="mt-3" id="mobileDetails" style="display:none;">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary bg-opacity-10 border-primary d-flex align-items-center">
                                        <i class="bi bi-phone-vibrate text-primary me-2"></i>
                                        <span class="fw-semibold">Informations Mobile Money</span>
                                    </div>
                                    <div class="card-body">
                                        <label for="phoneNumber" class="form-label">Numéro de téléphone</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+243</span>
                                            <input type="tel" class="form-control" id="phoneNumber" placeholder="XX XXX XXXX">
                                        </div>
                                        <div class="form-text mt-2">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Numéro associé à votre compte mobile money
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Détails Virement Bancaire -->
                            <div class="mt-3" id="bankDetails" style="display:none;">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary bg-opacity-10 border-primary d-flex align-items-center">
                                        <i class="bi bi-building text-primary me-2"></i>
                                        <span class="fw-semibold">Coordonnées Bancaires de l'École</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-2"><strong>Banque :</strong> EQUITY BCDC</div>
                                            <div class="col-12 col-md-6 mb-2"><strong>Code Banque :</strong> 12345</div>
                                            <div class="col-12 mb-2">
                                                <strong>Numéro de Compte USD :</strong>
                                                <span class="text-primary fw-bold">012-3456789-01</span>
                                            </div>
                                            <div class="col-12 col-md-6 mb-2"><strong>Devise :</strong> USD ($)</div>
                                            <div class="col-12 col-md-6 mb-2"><strong>Bénéficiaire :</strong> GROUPE SCOLAIRE MONT-AMBA</div>
                                        </div>
                                        <div class="alert alert-warning mt-3 mb-0">
                                            <small>
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                <strong>Important :</strong> Utilisez l'identifiant de l'élève comme référence de paiement.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton valider -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg py-3" name="valider">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                VALIDER LE PAIEMENT
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <p class="text-muted small">
                                <i class="bi bi-shield-check me-1"></i>
                                Vos informations sont sécurisées et confidentielles
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pt-4">
        <div class="col-12 col-lg-8">
            <h2 class="fw-bold">Derniers paiements</h2>
            <?php $r2 = $connexion -> prepare("SELECT * FROM paiements WHERE id_user = ?");
                  $r2 -> execute ([$_SESSION['id_user']]);
                  $response = $r2 -> fetchAll();
            ?>
            <?php if(empty($response)): ?>
                <h5 class="card-title">Aucun paiement recent pour le moment.</h5>
            <?php else: ?>
                <?php foreach($response as $ligne): ?>
                    <div class="card shadow border-0 mb-5;">
                        <div class="card-body p-3 p-md-5 ">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($ligne['id_eleve']) ?></h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-people me-1"></i>Methode de paiement : <?= htmlspecialchars($ligne['mode_paiement']) ?>
                                </p>
                                <p class="card-text fw-bold mt-auto mb-3">
                                    <i class="bi bi-cash me-1 text-success"></i>
                                    Montant payé :
                                    <?= htmlspecialchars($ligne['montant']) ?> $
                                </p>
                                <?php // recupération du nom de l'évènement
                                    $r3 = $connexion -> prepare ("SELECT description FROM evenements WHERE id_evenement = ?");
                                    $r3 -> execute ([$ligne['id_evenement']]);
                                    $name = $r3 -> fetchColumn();
                                ?>
                                <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </div>
    </div>
</div>
