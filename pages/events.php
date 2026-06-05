<?php
require_once 'config.php';

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
        mkdir($cheminImage, 0755, true);
    }
    // BUG FIXÉ : $_POST['image']['name'] est incorrect — les fichiers uploadés
    // sont dans $_FILES, pas $_POST. Correction → $_FILES['image']['name']
    $nomImage = null;
    if (!empty($_FILES['image']['name'])) {
        $nomImage = basename($_FILES['image']['name']);
        $ptmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($ptmp, $cheminImage . $nomImage);
    } else {
        // Si pas de nouvelle image, on garde l'ancienne
        $nomImage = $_POST['image_actuelle'] ?? null;
    }
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
        $nomImage = basename($_FILES['image']['name']);
        $ptmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($ptmp, $cheminImage . $nomImage);
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
        <i class="bi bi-plus-circle me-1"></i>Ajouter un événement
    </button>
</div>

<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Classe concernée</th>
                <th>Transport</th>
                <th>Entrée</th>
                <th>Encadrement</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($resultat)): ?>
            <tr><td colspan="8" class="text-muted fst-italic">Aucun événement enregistré.</td></tr>
            <?php endif; ?>
            <?php foreach ($resultat as $ligne): ?>
            <tr>
                <td><?= $ligne['id_evenement'] ?></td>
                <td><?= htmlspecialchars($ligne['classe_concernee']) ?></td>
                <td><?= htmlspecialchars($ligne['frais_transport']) ?> $</td>
                <td><?= htmlspecialchars($ligne['frais_entree']) ?> $</td>
                <td><?= htmlspecialchars($ligne['frais_encadrement']) ?> $</td>
                <td><?= htmlspecialchars($ligne['description']) ?></td>
                <td>
                    <?php if(!empty($ligne['photo'])): ?>
                    <img src="image/<?= htmlspecialchars($ligne['photo']) ?>" alt="Photo" style="max-width:70px;max-height:70px;object-fit:cover;border-radius:4px;">
                    <?php else: ?>
                    <span class="text-muted small">—</span>
                    <?php endif; ?>
                </td>
                <td class="text-nowrap">
                    <a href="?page=events&edit_id=<?= $ligne['id_evenement'] ?>" class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#modalEdit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="" method="post" class="d-inline">
                        <input type="hidden" name="delete_event" value="<?= $ligne['id_evenement'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm" name="delete"
                            onclick="return confirm('Supprimer cet événement ?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODALE AJOUT -->
<div class="modal fade" id="modalAjout" tabindex="-1" aria-labelledby="modalAjoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAjoutLabel">Ajouter un événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label class="form-label">Classe concernée</label>
                    <input type="text" name="classe_concernee" class="form-control mb-2" required>
                    <label class="form-label">Frais de transport ($)</label>
                    <input type="number" name="frais_transport" class="form-control mb-2" min="0" required>
                    <label class="form-label">Frais d'entrée ($)</label>
                    <input type="number" name="frais_entree" class="form-control mb-2" min="0" required>
                    <label class="form-label">Frais d'encadrement ($)</label>
                    <input type="number" name="frais_encadrement" class="form-control mb-2" min="0" required>
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control mb-2" required>
                    <label class="form-label">Photo</label>
                    <input type="file" name="image" class="form-control mb-3" accept="image/*">
                    <button type="submit" name="ajouter" class="btn btn-success w-100">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODALE EDITION -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Modifier un événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    onclick="window.location='dashboard.php?page=events'"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_evenement" value="<?= htmlspecialchars($evenement_edit['id_evenement'] ?? '') ?>">
                    <input type="hidden" name="image_actuelle" value="<?= htmlspecialchars($evenement_edit['photo'] ?? '') ?>">
                    <label class="form-label">Classe concernée</label>
                    <input type="text" name="classe_concernee" class="form-control mb-2" value="<?= htmlspecialchars($evenement_edit['classe_concernee'] ?? '') ?>">
                    <label class="form-label">Frais de transport ($)</label>
                    <input type="number" name="frais_transport" class="form-control mb-2" min="0" value="<?= htmlspecialchars($evenement_edit['frais_transport'] ?? '') ?>">
                    <label class="form-label">Frais d'entrée ($)</label>
                    <input type="number" name="frais_entree" class="form-control mb-2" min="0" value="<?= htmlspecialchars($evenement_edit['frais_entree'] ?? '') ?>">
                    <label class="form-label">Frais d'encadrement ($)</label>
                    <input type="number" name="frais_encadrement" class="form-control mb-2" min="0" value="<?= htmlspecialchars($evenement_edit['frais_encadrement'] ?? '') ?>">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control mb-2" value="<?= htmlspecialchars($evenement_edit['description'] ?? '') ?>">
                    <label class="form-label">Photo (laisser vide pour conserver l'actuelle)</label>
                    <input type="file" name="image" class="form-control mb-3" accept="image/*">
                    <button type="submit" name="modifier" class="btn btn-primary w-100">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['edit_id']) && $evenement_edit): ?>
<script>
    var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
    modalEdit.show();
</script>
<?php endif; ?>
