<?php
/* BUG FIXÉ : navbar.php était enveloppée dans un DOCTYPE/html/head/body complet
   alors qu'elle est incluse via home.php. Toute la structure HTML parasite est supprimée.
   Les liens CSS/JS sont chargés dans home.php. */
?>

<!-- NAVBAR (top) — Bootstrap Navbar avec hamburger fonctionnel -->
<nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="?page=acceuil">
            <div class="brand-icon d-flex align-items-center justify-content-center">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <span class="brand-name d-none d-sm-inline">Groupe Scolaire Mont Amba</span>
        </a>

        <!-- BUG FIXÉ : bouton hamburger avec data-bs-toggle/target corrects pour Bootstrap 5 collapse -->
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain"
                aria-controls="navbarMain"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="bi bi-list fs-4" style="color:var(--color-active);"></i>
        </button>

        <!-- Collapsible menu -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-1 mt-2 mt-lg-0">
                <li class="nav-item">
                    <a href="?page=acceuil" class="nav-link sidebar-link">
                        <i class="bi bi-house-fill"></i>
                        <span>Accueil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=comment" class="nav-link sidebar-link">
                        <i class="bi bi-question-circle-fill"></i>
                        <span>Comment ça marche</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=enfants" class="nav-link sidebar-link">
                        <i class="bi bi-person-badge"></i>
                        <span>Mes enfants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=paiement" class="nav-link sidebar-link">
                        <i class="bi bi-credit-card-fill"></i>
                        <span>Paiement</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=evenement" class="nav-link sidebar-link">
                        <i class="bi bi-calendar-event-fill"></i>
                        <span>Événement</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=calendrier" class="nav-link sidebar-link">
                        <i class="bi bi-calendar-week-fill"></i>
                        <span>Calendrier</span>
                    </a>
                </li>
            </ul>

            <!-- User info + Déconnexion -->
            <div class="d-flex align-items-center gap-2 py-2 py-lg-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-circle d-flex align-items-center justify-content-center flex-shrink-0">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <!-- BUG FIXÉ : $result non défini ici car navbar.php est un include ;
                             la variable $result est définie dans home.php et disponible ici -->
                        <div class="user-name"><?= htmlspecialchars($result['nom'] ?? 'Utilisateur') ?></div>
                        <small class="user-role">Utilisateur</small>
                    </div>
                </div>
                <a href="logout.php" class="btn btn-deconnexion ms-2">
                    <i class="bi bi-box-arrow-left me-1"></i>Déconnexion
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- active link sur la navbar selon ?page= en cours -->
<script>
(function() {
    var params = new URLSearchParams(window.location.search);
    var page = params.get('page') || 'acceuil';
    document.querySelectorAll('#mainNavbar .nav-link').forEach(function(lien) {
        var href = lien.getAttribute('href') || '';
        if (href.indexOf('page=' + page) !== -1) {
            lien.classList.add('active');
        }
    });
})();
</script>
