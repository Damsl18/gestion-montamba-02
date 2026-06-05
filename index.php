<?php
session_start();
require_once 'config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connecter'])){
    $id = htmlspecialchars($_POST['id']);
    $password = htmlspecialchars($_POST['password']);

    $request = $connexion -> prepare ("SELECT * FROM users WHERE id_user = ?");
    $request -> execute ([
        $id
    ]);
    $resultat = $request -> fetch();
    if ( $resultat && password_verify($password, $resultat['password']) ) {
        if($resultat['type'] === 'admin'){
            $_SESSION['id'] = $id;
            header('location:dashboard.php');
        } else {
            $_SESSION['id_user'] = $resultat['id_user'];
            header('location:home.php');
        }
    } else {
        $alert = true;
    }   
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Groupe Scolaire Mont-Amba</title>

    <!-- Bootstrap -->
    <link href="bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="styles/connecter.css">
</head>
<body>

<!-- BUG FIXÉ : utilisation du container Bootstrap standard + classes responsives -->
<div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="login-box">
        <div class="head">
            <div class="user-icon d-flex align-items-center justify-content-center mb-4">
                <!-- BUG FIXÉ : backslash "images\logo..." remplacé par slash normal -->
                <img src="images/logo-removebg-preview.png" alt="Logo de l'école" class="img-fluid" style="max-height:80px;">
            </div>
            <h4 class="text-center mb-4">Connectez-vous à votre espace</h4>
        </div>
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Identifiant</label>
                <input type="text" name="id" class="form-control" placeholder="Entrez votre identifiant" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
            </div>
            <?php if(isset($alert)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    Identifiant ou mot de passe incorrect
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary w-100 mt-2" name="connecter">
                Se connecter
            </button>
        </form>
    </div>
</div>

<script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
