<?php 
  require_once 'config.php';
  $request = $connexion->prepare("SELECT nom FROM users WHERE id_user = ?");
  $request->execute([$_SESSION['id']]);
  $resultat = $request->fetch();
  $nom = $resultat ? $resultat['nom'] : 'Admin';
?>

<!-- BUG FIXÉ : la sidebar était enveloppée dans un DOCTYPE/html/head/body complet
     alors qu'elle est un include. Suppression de tout le wrapper HTML parasite.
     Les liens CSS/JS nécessaires sont maintenant chargés dans dashboard.php -->

<div id="overlay" class="sidebar-overlay" onclick="fermerSidebar()"></div>

<aside id="sidebar" class="sidebar d-flex flex-column">
    <div class="sidebar-brand d-flex align-items-center gap-2 px-3 py-4">
        <div class="brand-icon d-flex align-items-center justify-content-center">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <span class="brand-name">Groupe Scolaire Mont Amba</span>
    </div>

    <nav class="flex-grow-1 overflow-y-auto px-2 pb-2">
        <ul class="nav flex-column gap-1">

            <li class="nav-item">
                <a href="?page=dashboard" class="nav-link sidebar-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="?page=users" class="nav-link sidebar-link">
                    <i class="bi bi-people-fill"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="?page=students" class="nav-link sidebar-link">
                    <i class="bi bi-person-badge"></i>
                    <span>Élèves</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="?page=events" class="nav-link sidebar-link">
                    <i class="bi bi-calendar-event-fill"></i>
                    <span>Événements</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="?page=calendrier" class="nav-link sidebar-link">
                    <i class="bi bi-award-fill"></i>
                    <span>Calendrier</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="?page=paiement" class="nav-link sidebar-link">
                    <i class="bi bi-credit-card-fill"></i>
                    <span>Paiement</span>
                </a>
            </li>

        </ul>
    </nav>

    <div class="sidebar-footer px-3 py-3 mt-auto">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="avatar-circle d-flex align-items-center justify-content-center flex-shrink-0">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="overflow-hidden">
                <!-- BUG FIXÉ : h1 utilisé pour le nom d'utilisateur (sémantique incorrecte) → p -->
                <p class="user-name text-truncate mb-0"><?= htmlspecialchars($nom) ?></p>
                <small class="user-role">Administrateur</small>
            </div>
        </div>
        <a href="logout.php" class="btn btn-deconnexion w-100">
            <i class="bi bi-box-arrow-left me-2"></i>Déconnexion
        </a>
    </div>
</aside>

<!-- TOPBAR mobile -->
<header id="topbar" class="topbar d-flex align-items-center px-3">
    <!-- BUG FIXÉ : bouton hamburger appelait ouvrirSidebar() mais la fonction
         est définie dans sidebar.js chargé après → OK car le script est en bas de page.
         Ajout aria-label pour accessibilité. -->
    <button class="btn btn-toggle me-3 d-lg-none" onclick="ouvrirSidebar()" aria-label="Ouvrir le menu">
        <i class="bi bi-list fs-4"></i>
    </button>
    <span class="topbar-title">Groupe Scolaire Mont Amba</span>
</header>
