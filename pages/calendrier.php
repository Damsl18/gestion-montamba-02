<?php
require_once 'config.php';

// Récupération du calendrier à éditer
$calendrier_edit = null;
if (isset($_GET['edit_id'])) {
    $stmt = $connexion->prepare("SELECT * FROM calendriers WHERE id_calendrier = ?");
    $stmt->execute([$_GET['edit_id']]);
    $calendrier_edit = $stmt->fetch();
}

// Modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $stmt = $connexion->prepare("UPDATE calendriers SET jour=?, dates=?, evenement=? WHERE id_calendrier=?");
    $stmt->execute([
        $_POST['jour'],
        $_POST['dates'],
        $_POST['evenement'],
        $_POST['id_calendrier']
    ]);
    echo "<script>window.location='dashboard.php?page=calendrier';</script>";
}

// Ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $stmt = $connexion->prepare("INSERT INTO calendriers (jour, dates, evenement) VALUES (?, ?, ?)");
    $stmt->execute([
        $_POST['jour'],
        $_POST['dates'],
        $_POST['evenement']
    ]);
    echo "<script>window.location='dashboard.php?page=calendrier';</script>";
}

// Suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $requete_delete = $connexion->prepare("DELETE FROM calendriers WHERE id_calendrier = ?");
    $requete_delete->execute([$_POST['delete_calendar']]);
    echo "<script>window.location='dashboard.php?page=calendrier';</script>";
}

$request = $connexion->prepare("SELECT * FROM calendriers");
$request->execute();
$resultat = $request->fetchAll();
?>

<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="h4 mb-0">Gestion du calendrier scolaire</h1>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAjout">
        Ajouter une date
    </button>
</div>

<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Jour</th>
                <th>Date</th>
                <th>Évènement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultat as $ligne): ?>
            <tr>
                <td><?= htmlspecialchars($ligne['jour']) ?></td>
                <td><?= htmlspecialchars($ligne['dates']) ?></td>
                <td><?= htmlspecialchars($ligne['evenement']) ?></td>
                <td>
                    <a href="?page=calendrier&edit_id=<?= $ligne['id_calendrier'] ?>" class="btn btn-primary btn-sm">Editer</a>
                    <form action="" method="post" class="d-inline">
                        <input type="hidden" name="delete_calendar" value="<?= $ligne['id_calendrier'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm" name="delete"
                            onclick="return confirm('Supprimer cette date ?')">Supprimer</button>
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
                <h5 class="modal-title">Ajouter une date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <label class="form-label">Jour</label>
                    <select class="form-select" name="jour" class="form-control mb-2" required>
                        <option value="">--Sélectionnez un jour--</option>
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                        <option value="Dimanche">Dimanche</option>
                    </select>
                    <label class="form-label">Date</label>
                    <input type="date" name="dates" class="form-control mb-2" required>
                    <label class="form-label">Événement</label>
                    <input type="text" name="evenement" class="form-control mb-2" required>
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
                <h5 class="modal-title">Modifier une date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    onclick="window.location='dashboard.php?page=calendrier'"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="id_calendrier" value="<?= $calendrier_edit['id_calendrier'] ?? '' ?>">
                    <label class="form-label">Jour</label>
                    <input type="text" name="jour" class="form-control mb-2" value="<?= htmlspecialchars($calendrier_edit['jour'] ?? '') ?>">
                    <label class="form-label">Date</label>
                    <input type="date" name="dates" class="form-control mb-2" value="<?= htmlspecialchars($calendrier_edit['dates'] ?? '') ?>">
                    <label class="form-label">Événement</label>
                    <input type="text" name="evenement" class="form-control mb-2" value="<?= htmlspecialchars($calendrier_edit['evenement'] ?? '') ?>">
                    <button type="submit" name="modifier" class="btn btn-primary w-100">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['edit_id']) && $calendrier_edit): ?>
<script>
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
</script>
<?php endif; ?>