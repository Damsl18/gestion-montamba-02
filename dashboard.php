<?php
session_start();
if ( !isset($_SESSION['id'])){
    header('location: index.php');
    exit; /* BUG FIXÉ : exit manquant après header() redirect */
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord — Admin</title>
    <!-- BUG FIXÉ : suppression du lien vers style.css inexistant -->
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <!-- BUG FIXÉ : chemin sidebar/side.css était correct mais le fichier
         incluait lui-même des <head> parasites ; on charge depuis la racine -->
    <link rel="stylesheet" href="sidebar/side.css">
    <!-- Bootstrap Icons via CDN (requis par la sidebar) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Font Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar/sidebar.php'; ?>

    <!-- BUG FIXÉ : main-content avait margin-top:2.5rem fixe, doit être 0 car
         le décalage topbar mobile est déjà géré dans side.css via padding-top -->
    <main class="main-content p-3 p-md-4">
        <?php
            switch ($page) {
                case 'students':
                    include 'pages/students.php';
                    break;
                case 'events':
                    include 'pages/events.php';
                    break;
                case 'users':
                    include 'pages/users.php';
                    break;
                case 'dashboard':
                    include 'pages/tableau.php';
                    break;
                case 'calendrier':
                    include 'pages/calendrier.php';
                    break;
                case 'paiement':
                    include 'pages/paiement.php';
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

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="sidebar/sidebar.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            document.getElementById('scrollTop').style.display = window.scrollY > 300 ? 'block' : 'none';
        });
    </script>
</body>
</html>
