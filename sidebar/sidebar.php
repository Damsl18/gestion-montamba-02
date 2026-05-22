<?php 
  require_once 'config.php';
  $request = $connexion->prepare("SELECT nom FROM users WHERE id_user = ?");
  $request->execute([$_SESSION['id']]);
  $resultat = $request->fetch();
  $nom = $resultat['nom'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Scolaire</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="side.css"/>
</head>
<body>
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
          <a href="?page=events" class="nav-link sidebar-link ">
            <i class="bi bi-calendar-event-fill"></i>
            <span>Événements</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="?page=calendrier" class="nav-link sidebar-link ">
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

          <h1 class="user-name text-truncate mb-0"><?= htmlspecialchars($nom) ?></h1>
          <small class="user-role">Administrateur</small>
        </div>
      </div>
      <a href="logout.php" class="btn btn-deconnexion w-100">
        <i class="bi bi-box-arrow-left me-2"></i>Déconnexion
      </a>
    </div>

  </aside>

  <!-- ══════════════ TOPBAR (mobile) ══════════════ -->
  <header id="topbar" class="topbar d-flex align-items-center px-3">
    <button class="btn btn-toggle me-3 d-lg-none" onclick="ouvrirSidebar()" aria-label="Ouvrir le menu">
      <i class="bi bi-list"></i>
    </button>
    <span class="topbar-title">Groupe Scolaire Mont Amba</span>
  </header>

  <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script src="sidebar.js"></script>
</body>
</html>
