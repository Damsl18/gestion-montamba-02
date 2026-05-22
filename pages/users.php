<?php
require_once 'config.php';

// Récupération de l'utilisateur à éditer
$user_edit = null;
if (isset($_GET['edit_id'])) {
    $stmt = $connexion->prepare("SELECT * FROM users WHERE id_user = ?");
    $stmt->execute([$_GET['edit_id']]);
    $user_edit = $stmt->fetch();
}

// Modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $stmt = $connexion->prepare("UPDATE users SET nom=?, post_nom=?, prenom=?, adresse=?, telephone=? WHERE id_user=?");
    $stmt->execute([
        $_POST['nom'],
        $_POST['post_nom'],
        $_POST['prenom'],
        $_POST['adresse'],
        $_POST['telephone'],
        $_POST['id_user']
    ]);
    echo "<script>window.location='dashboard.php?page=users';</script>";
}

// Ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $stmt = $connexion->prepare("INSERT INTO users (nom, post_nom, prenom, adresse, telephone) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nom'],
        $_POST['post_nom'],
        $_POST['prenom'],
        $_POST['adresse'],
        $_POST['telephone']
    ]);
    echo "<script>window.location='dashboard.php?page=users';</script>";
}

// Suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $requete_delete = $connexion->prepare("DELETE FROM users WHERE id_user = ?");
    $requete_delete->execute([$_POST['delete_user']]);
    echo "<script>window.location='dashboard.php?page=users';</script>";
}

$request = $connexion->prepare("SELECT * FROM users");
$request->execute();
$resultat = $request->fetchAll();
?>

<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="h4 mb-0">Gestion des utilisateurs</h1>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAjout">
        Ajouter un utilisateur
    </button>
</div>

<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Post-nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultat as $ligne): ?>
            <tr>
                <td><?= $ligne['id_user'] ?></td>
                <td><?= htmlspecialchars($ligne['nom']) ?></td>
                <td><?= htmlspecialchars($ligne['post_nom']) ?></td>
                <td><?= htmlspecialchars($ligne['prenom']) ?></td>
                <td><?= htmlspecialchars($ligne['adresse']) ?></td>
                <td><?= htmlspecialchars($ligne['telephone']) ?></td>
                <td>
                    <a href="?page=users&edit_id=<?= $ligne['id_user'] ?>" class="btn btn-primary btn-sm">Editer</a>
                    <form action="" method="post" class="d-inline">
                        <input type="hidden" name="delete_user" value="<?= $ligne['id_user'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm" name="delete"
                            onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODALE AJOUT -->
<div class="modal fade" id="modalAjout" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control mb-2" required>
                    <label class="form-label">Post-nom</label>
                    <input type="text" name="post_nom" class="form-control mb-2" required>
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control mb-2" required>
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control mb-2" required>
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control mb-2" required>
                    <button type="submit" name="ajouter" class="btn btn-success w-100">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODALE EDITION -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    onclick="window.location='dashboard.php?page=users'"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="id_user" value="<?= $user_edit['id_user'] ?? '' ?>">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control mb-2" value="<?= htmlspecialchars($user_edit['nom'] ?? '') ?>">
                    <label class="form-label">Post-nom</label>
                    <input type="text" name="post_nom" class="form-control mb-2" value="<?= htmlspecialchars($user_edit['post_nom'] ?? '') ?>">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control mb-2" value="<?= htmlspecialchars($user_edit['prenom'] ?? '') ?>">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control mb-2" value="<?= htmlspecialchars($user_edit['adresse'] ?? '') ?>">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control mb-2" value="<?= htmlspecialchars($user_edit['telephone'] ?? '') ?>">
                    <button type="submit" name="modifier" class="btn btn-primary w-100">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['edit_id']) && $user_edit): ?>
<script>
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
</script>
<?php endif; ?>