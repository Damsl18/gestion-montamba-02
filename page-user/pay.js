// Gestion de l'affichage des champs de paiement
document.addEventListener('DOMContentLoaded', function() {
    const mobileRadio = document.getElementById('mobilePayment');
    const bankRadio = document.getElementById('bankTransfer');
    const mobileDetails = document.getElementById('mobileDetails');
    const bankDetails = document.getElementById('bankDetails');
    const reasonSelect = document.getElementById('reason');
    
    // Fonction pour afficher/masquer les détails de paiement
    function togglePaymentDetails() {
        if (mobileRadio.checked) {
            mobileDetails.style.display = 'block';
            bankDetails.style.display = 'none';
        } else if (bankRadio.checked) {
            mobileDetails.style.display = 'none';
            bankDetails.style.display = 'block';
        } else {
            mobileDetails.style.display = 'none';
            bankDetails.style.display = 'none';
        }
    }
    
    // Ajouter les écouteurs d'événements
    if (mobileRadio) mobileRadio.addEventListener('change', togglePaymentDetails);
    if (bankRadio) bankRadio.addEventListener('change', togglePaymentDetails);
    
    // Initialiser l'affichage
    togglePaymentDetails();
});
// Gestion du champ "Autre" pour le motif
const reasonSelect = document.getElementById('reason');
const otherReasonGroup = document.getElementById('otherReasonGroup');

if (reasonSelect && otherReasonGroup) {
    function toggleOtherReason() {
        if (reasonSelect.value === 'autre') {
            otherReasonGroup.style.display = 'block';
        } else {
            otherReasonGroup.style.display = 'none';
        }
    }
    
    reasonSelect.addEventListener('change', toggleOtherReason);
    toggleOtherReason();
}