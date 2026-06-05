// BUG FIXÉ : toute la logique est dans DOMContentLoaded pour éviter
// les erreurs si les éléments ne sont pas encore chargés

document.addEventListener('DOMContentLoaded', function() {

    const mobileRadio   = document.getElementById('mobilePayment');
    // BUG FIXÉ : l'ID du radio "Virement Bancaire" dans pay.php était 'Paiement banquaire'
    // (avec espace et accents — invalide) ; corrigé dans pay.php → 'bankTransfer'
    const bankRadio     = document.getElementById('bankTransfer');
    const mobileDetails = document.getElementById('mobileDetails');
    const bankDetails   = document.getElementById('bankDetails');

    // Affichage conditionnel des détails de paiement
    function togglePaymentDetails() {
        if (!mobileDetails || !bankDetails) return;
        if (mobileRadio && mobileRadio.checked) {
            mobileDetails.style.display = 'block';
            bankDetails.style.display   = 'none';
        } else if (bankRadio && bankRadio.checked) {
            mobileDetails.style.display = 'none';
            bankDetails.style.display   = 'block';
        } else {
            mobileDetails.style.display = 'none';
            bankDetails.style.display   = 'none';
        }
    }

    if (mobileRadio) mobileRadio.addEventListener('change', togglePaymentDetails);
    if (bankRadio)   bankRadio.addEventListener('change', togglePaymentDetails);
    togglePaymentDetails();

    // BUG FIXÉ : reasonSelect était déclaré deux fois (une fois dans DOMContentLoaded
    // et une fois à la portée globale) → ReferenceError dans certains navigateurs.
    // Tout regroupé ici.
    const reasonSelect    = document.getElementById('reason');
    const otherReasonGroup = document.getElementById('otherReasonGroup');

    function toggleOtherReason() {
        if (!reasonSelect || !otherReasonGroup) return;
        otherReasonGroup.style.display = reasonSelect.value === 'autre' ? 'block' : 'none';
    }

    if (reasonSelect) {
        reasonSelect.addEventListener('change', toggleOtherReason);
        toggleOtherReason();
    }
});
