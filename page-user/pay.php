<?php
    require_once 'config.php';
    $requete = $connexion -> prepare ("SELECT * FROM evenements");
    $requete -> execute();
    $evenements = $requete -> fetchAll();
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valider'])){
        $stmt = $connexion->prepare("INSERT INTO paiements (categorie, motif, montant, mode_paiement, id_user, id_eleve, id_evenement) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $req = $connexion->prepare("SELECT description FROM evenements WHERE id_evenement = ?");
        if(!($_POST['reason'] === 'autre' || empty($_POST['other_reason']))){
            $req->execute([$_POST['reason']]);
            $res = $req->fetch();
        }
        $motif = $_POST['reason'] === 'autre' ? $_POST['other_reason'] : $res['description'];
        $stmt->execute([
            $_POST['categorie'],
            $motif,
            $_POST['montant'],
            $_POST['paymentMethod'],
            $_SESSION['id_user'],
            $_POST['id_eleve'],
            $_POST['reason'] !== 'autre' ? $_POST['reason'] : null
        ]);
        echo "<script>alert('Paiement enregistré avec succès !');</script>";
    }

?>

<div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle p-3 mb-3">
                        <i class="bi bi-cash-stack text-white fs-1"></i>
                    </div>
                    <h1 class="fw-bold text-primary">Paiement Scolaire</h1>
                
                </div>
                <form action="" method="POST" class="payment-form">
                    <div class=" shadow border-0">
                        <div class="card-body p-4 p-md-5">
                            <div class="form-section mb-4">
                                <h4 class="fw-bold mb-3">
                                    <i class="bi bi-person-circle text-primary me-2"></i>
                                    Identification de l'Élève
                                </h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="studentId" class="form-label fw-semibold">
                                            <i class="bi bi-key me-1"></i>
                                            Identifiant de l'élève
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-person-fill text-primary"></i>
                                            </span>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="studentId" 
                                                   placeholder="Ex: ELV2024001"
                                                   required
                                                   name="id_eleve">
                                                   
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="categorie" class="form-label fw-semibold">Catégorie</label>
                                        <select class="form-select" id="categorie" name="categorie" required>
                                            <option value="" selected disabled>Sélectionnez...</option>
                                            <option value="scolarite">Extérieur</option>
                                            <option value="uniforme">Autres</option>
                                            <option value="cantine">ORPUK</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-section mb-4">
                                <h4 class="fw-bold mb-3">
                                    <i class="bi bi-wallet2 text-primary me-2"></i>
                                    Détails du Paiement
                                </h4>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <label for="reason" class="form-label fw-semibold">Motif du paiement</label>
                                        <select class="form-select" id="reason" name="reason" required>
                                            <?php foreach($evenements as $evenement): ?>
                                                <option value="<?= htmlspecialchars($evenement['id_evenement']) ?>">
                                                    <?= htmlspecialchars($evenement['description']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <option value="autre">Autre</option>
                                        </select>
                                        <div id="otherReasonGroup" style="display: none;" class="currency-other-group">
                                            <label for="otherReason" class="form-label fw-semibold">Précisez le motif</label>
                                            <input type="text" 
                                                class="form-control" 
                                                id="otherReason" 
                                                name="other_reason" 
                                                placeholder="Entrez le motif du paiement">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-semibold d-block mb-3">
                                        <i class="bi bi-credit-card text-primary me-1"></i>
                                        Mode de paiement
                                    </label>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="payment-option card border h-100">
                                                <div class="card-body text-center p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="radio" 
                                                               name="paymentMethod" 
                                                               id="mobilePayment" 
                                                               value="Mobile money"
                                                               required>
                                                        <label class="form-check-label fw-semibold stretched-link" for="mobilePayment">
                                                            <div class="mb-2">
                                                                <i class="bi bi-phone-fill fs-2 text-primary"></i>
                                                            </div>
                                                            Paiement Mobile
                                                        </label>
                                                    </div>
                                                    <p class="text-muted small mt-2 mb-0">
                                                        Orange Money, M-Pesa, etc.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="payment-option card border h-100">
                                                <div class="card-body text-center p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="radio" 
                                                               name="paymentMethod" 
                                                               id="Paiement banquaire" 
                                                               value="bank">
                                                        <label class="form-check-label fw-semibold stretched-link" for="Paiement banquaire">
                                                            <div class="mb-2">
                                                                <i class="bi bi-bank2 fs-2 text-primary"></i>
                                                            </div>
                                                            Virement Bancaire
                                                        </label>
                                                    </div>
                                                    <p class="text-muted small mt-2 mb-0">
                                                        Transfert direct
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="payment-details" id="mobileDetails" style="display: none;">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary bg-opacity-10 border-primary d-flex align-items-center">
                                            <i class="bi bi-phone-vibrate text-primary me-2"></i>
                                            <span class="fw-semibold">Informations Mobile Money</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="phoneNumber" class="form-label">
                                                    Numéro de téléphone
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">+243</span>
                                                    <input type="tel" 
                                                           class="form-control" 
                                                           id="phoneNumber" 
                                                           placeholder="XX XXX XXXX">
                                                </div>
                                                <div class="form-text mt-2">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Numéro associé à votre compte mobile money
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="payment-details" id="bankDetails" style="display: none;">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary bg-opacity-10 border-primary d-flex align-items-center">
                                            <i class="bi bi-building text-primary me-2"></i>
                                            <span class="fw-semibold">Coordonnées Bancaires de l'École</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="bank-info">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Banque :</strong> BANK OF AFRICA
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Code Banque :</strong> 12547
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <strong>Numéro de Compte USD :</strong>
                                                        <span class="text-primary fw-bold">012-3456789-01</span>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Devise :</strong> USD ($)
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Bénéficiaire :</strong> ÉCOLE LES SAVANTS
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="alert alert-warning mt-3 mb-0">
                                                <small>
                                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                                    <strong>Important :</strong> Utilisez l'identifiant de l'élève comme référence de paiement
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-success btn-lg py-3" name="valider">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    VALIDER LE PAIEMENT
                                </button>
                            </div>
                            <div class="text-center mt-4">
                                <p class="text-muted small">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Vos informations sont sécurisées et confidentielles
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>