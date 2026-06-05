<?php
session_start();
require_once 'config.php';
if ( !isset($_SESSION['id_user'])){
    header('location: index.php');
    exit;
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'acceuil';
    $req = $connexion -> prepare("SELECT * FROM users WHERE id_user = ?");
    $req -> execute([$_SESSION['id_user']]);
    $result = $req -> fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Parent — Groupe Scolaire Mont-Amba</title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sidebar/nav.css">

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Font Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar/navbar.php'; ?>

    <main class="main-content p-3 p-md-4">
        <?php
            switch ($page) {
                case 'acceuil':
                    include 'page-user/acceuil.php';
                    break;
                case 'comment':
                    include 'page-user/commentpayer.php';
                    break;
                case 'enfants':
                    include 'page-user/children.php';
                    break;
                case 'paiement':
                    include 'page-user/pay.php';
                    break;
                case 'evenement':
                    include 'page-user/event.php';
                    break;
                case 'calendrier':
                    include 'page-user/calendrier.php';
                    break;
                default:
                    echo "<div class='alert alert-warning'>Page non trouvée</div>";
            }
        ?>
    </main>

    <!-- Bouton retour haut -->
    <button id="scrollTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="btn btn-secondary position-fixed bottom-0 end-0 m-3 rounded-circle"
            style="width:44px;height:44px;display:none;z-index:900;">
        ↑
    </button>

    <footer class="footer mt-auto py-4 bg-light border-top">
        <div class="container">
            <div class="row align-items-center gy-2">
                <div class="col-12 col-md-4 text-center text-md-start">
                    <img src="./images/logo-removebg-preview.png" class="img-fluid" style="max-height:50px;" alt="Logo Mont-Amba">
                </div>
                <div class="col-12 col-md-4 text-center">
                    <span class="text-muted">&copy; 2026 ~ Groupe Scolaire Mont-Amba</span><br>
                    <span class="text-muted">Groupe SILLKLMTMM</span>
                </div>
                <div class="col-12 col-md-4 text-center text-md-end">
                    <a href="#" class="text-muted me-3">Mentions légales</a>
                    <!-- BUG FIXÉ : "conidentialité" → "confidentialité" -->
                    <a href="#" class="text-muted me-3">Politique de confidentialité</a>
                    <a href="https://wa.me/+243842555645" target="_blank" rel="noopener" class="text-muted">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- BUG FIXÉ : un seul script Bootstrap bundle, chemin correct depuis la racine -->
    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="page-user/pay.js"></script>
    <!-- BUG FIXÉ : scroll.js inexistant → logique inline -->
    <script>
        window.addEventListener('scroll', function() {
            document.getElementById('scrollTop').style.display = window.scrollY > 300 ? 'block' : 'none';
        });
    </script>
</body>
</html>
