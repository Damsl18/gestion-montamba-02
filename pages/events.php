<?php
require_once 'config.php';

// Récupération de l'événement à éditer
$evenement_edit = null;
if (isset($_GET['edit_id'])) {
    $stmt = $connexion->prepare("SELECT * FROM evenements WHERE id_evenement = ?");
    $stmt->execute([$_GET['edit_id']]);
    $evenement_edit = $stmt->fetch();
}

// Modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $cheminImage = "image/";
    if(!file_exists($cheminImage)){
        mkdir($cheminImage);
    }
    $nomImage = $_POST['image']['name'];
    $ptmp = $_FILES['image']['tmp_name'];
    $chemin = $cheminImage . basename($nomImage);
    move_uploaded_file($ptmp, $chemin);
    $stmt = $connexion->prepare("UPDATE evenements SET classe_concernee=?, frais_transport=?, frais_entree=?, frais_encadrement=?, description=?, photo=? WHERE id_evenement=?");
    $stmt->execute([
        $_POST['classe_concernee'],
        $_POST['frais_transport'],
        $_POST['frais_entree'],
        $_POST['frais_encadrement'],
        $_POST['description'],
        $nomImage,
        $_POST['id_evenement']
    ]);
    if($stmt){
        echo "<script>alert('Événement modifié avec succès');</script>";
    }
    echo "<script>window.location='dashboard.php?page=events';</script>";
}

// Ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $cheminImage = "image/";
    if(!file_exists($cheminImage)){
        mkdir($cheminImage, 0755, true);
    }
    $nomImage = null;
    if (!empty($_FILES['image']['name'])) {
        $nomImage = $_FILES['image']['name'];
        $ptmp = $_FILES['image']['tmp_name'];
        $chemin = $cheminImage . basename($nomImage);
        move_uploaded_file($ptmp, $chemin);
    }
    $stmt = $connexion->prepare("INSERT INTO evenements (classe_concernee, frais_transport, frais_entree, frais_encadrement, description, photo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['classe_concernee'],
        $_POST['frais_transport'],
        $_POST['frais_entree'],
        $_POST['frais_encadrement'],
        $_POST['description'],
        $nomImage
    ]);
    if($stmt){
        echo "<script>alert('Événement ajouté avec succès');</script>";
    }
    echo "<script>window.location='dashboard.php?page=events';</script>";
}

// Suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $requete_delete = $connexion->prepare("DELETE FROM evenements WHERE id_evenement = ?");
    $requete_delete->execute([$_POST['delete_event']]);
    echo "<script>window.location='dashboard.php?page=events';</script>";
}

$request = $connexion->prepare("SELECT * FROM evenements");
$request->execute();
$resultat = $request->fetchAll();
?>

<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="h4 mb-0">Gestion des événements</h1>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAjout">
        Ajouter un événement
    </button>
</div>

<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Classe concernée</th>
                <th>Frais transport</th>
                <th>Frais entrée</th>
                <th>Frais encadrement</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultat as $ligne): ?>
            <tr>
                <td><?= $ligne['id_evenement'] ?></td>
                <td><?= htmlspecialchars($ligne['classe_concernee']) ?></td>
                <td><?= htmlspecialchars($ligne['frais_transport']) ?></td>
                <td><?= htmlspecialchars($ligne['frais_entree']) ?></td>
                <td><?= htmlspecialchars($ligne['frais_encadrement']) ?></td>
                <td><?= htmlspecialchars($ligne['description']) ?></td>
                <td><img src="<?= htmlspecialchars($ligne['photo']) ?>" alt="Photo" style="max-width:80px;max-height:80px;"></td>
                <td>
                    <a href="?page=events&edit_id=<?= $ligne['id_evenement'] ?>" class="btn btn-primary btn-sm">Editer</a>
                    <form action="" method="post" class="d-inline">
                        <input type="hidden" name="delete_event" value="<?= $ligne['id_evenement'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm" name="delete"
                            onclick="return confirm('Supprimer cet événement ?')">Supprimer</button>
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
                <h5 class="modal-title">Ajouter un événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label class="form-label">Classe concernée</label>
                    <input type="text" name="classe_concernee" class="form-control mb-2" required>
                    <label class="form-label">Frais de transport</label>
                    <input type="number" name="frais_transport" class="form-control mb-2" required>
                    <label class="form-label">Frais d'entrée</label>
                    <input type="number" name="frais_entree" class="form-control mb-2" required>
                    <label class="form-label">Frais d'encadrement</label>
                    <input type="number" name="frais_encadrement" class="form-control mb-2" required>
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control mb-2" required>
                    <label class="form-label">Photo</label>
                    <input type="hidden" src="" alt="" name="image_actuelle" value="">
                    <input type="file" name="image" class="form-control mb-2">
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
                <h5 class="modal-title">Modifier un événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    onclick="window.location='dashboard.php?page=events'"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_evenement" value="<?= $evenement_edit['id_evenement'] ?? '' ?>">
                    <label class="form-label">Classe concernée</label>
                    <input type="text" name="classe_concernee" class="form-control mb-2" value="<?= htmlspecialchars($evenement_edit['classe_concernee'] ?? '') ?>">
                    <label class="form-label">Frais de transport</label>
                    <input type="number" name="frais_transport" class="form-control mb-2" value="<?= htmlspecialchars($evenement_edit['frais_transport'] ?? '') ?>">
                    <label class="form-label">Frais d'entrée</label>
                    <input type="number" name="frais_entree" class="form-control mb-2" value="<?= htmlspecialchars($evenement_edit['frais_entree'] ?? '') ?>">
                    <label class="form-label">Frais d'encadrement</label>
                    <input type="number" name="frais_encadrement" class="form-control mb-2" value="<?= htmlspecialchars($evenement_edit['frais_encadrement'] ?? '') ?>">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control mb-2" value="<?= htmlspecialchars($evenement_edit['description'] ?? '') ?>">
                    <label class="form-label">Photo</label>
                    <input type="file" name="image" class="form-control mb-2">
                    <button type="submit" name="modifier" class="btn btn-primary w-100">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['edit_id']) && $evenement_edit): ?>
<script>
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
</script>
<?php endif; ?>

