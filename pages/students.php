<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $nom     = trim(htmlspecialchars($_POST['nom']));
    $postnom = trim(htmlspecialchars($_POST['post_nom']));
    $prenom  = trim(htmlspecialchars($_POST['prenom']));
    $classe  = trim(htmlspecialchars($_POST['classe']));
    $option  = trim(htmlspecialchars($_POST['option']));
    $categorie = trim(htmlspecialchars($_POST['categorie']));
    $sexe    = trim(htmlspecialchars($_POST['sexe']));
    $parent  = trim(htmlspecialchars($_POST['parent']));
    $requete = $connexion->prepare("INSERT INTO eleves (nom, post_nom, prenom, classe, options, categorie, sexe, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $requete->execute([$nom, $postnom, $prenom, $classe, $option, $categorie, $sexe, $parent]);
    echo "<script>window.location='dashboard.php?page=students';</script>";
}

$student_edit = null;
if (isset($_GET['edit_id'])) {
    $stmt = $connexion->prepare("SELECT * FROM eleves WHERE id_eleve = ?");
    $stmt->execute([$_GET['edit_id']]);
    $student_edit = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $stmt = $connexion->prepare("UPDATE eleves SET nom=?, prenom=?, post_nom=?, classe=?, options=?, categorie=?, sexe=?, id_user=? WHERE id_eleve=?");
    $stmt->execute([
        $_POST['nom'], $_POST['prenom'], $_POST['post_nom'],
        $_POST['classe'], $_POST['options'], $_POST['categorie'],
        $_POST['sexe'], $_POST['parent'], $_POST['id_eleve']
    ]);
    echo "<script>window.location='dashboard.php?page=students';</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id_eleve = $_POST['delete_student'];
    $requete_delete = $connexion->prepare("DELETE FROM eleves WHERE id_eleve = ?");
    $requete_delete->execute([$id_eleve]);
    echo "<script>window.location='dashboard.php?page=students';</script>";
}

$EB7  = ['7e',    'Education de base A', 'Education de base B'];
$EB8  = ['8e',    'Education de base A', 'Education de base B'];
$hum1 = ['1ère',  'Scientifique', 'Littéraire', 'Commerciale'];
$hum2 = ['2ème',  'Scientifique', 'Littéraire', 'Commerciale'];
$hum3 = ['3ème',  'Scientifique', 'Littéraire', 'Commerciale'];
$hum4 = ['4ème',  'Scientifique', 'Littéraire', 'Commerciale'];

$sections = [
    ['id' => 'eb7A',    'titre' => '7e Education de Base A',         'classe' => $EB7[0],  'option' => $EB7[1]],
    ['id' => 'eb7B',    'titre' => '7e Education de Base B',         'classe' => $EB7[0],  'option' => $EB7[2]],
    ['id' => 'eb8A',    'titre' => '8e Education de Base A',         'classe' => $EB8[0],  'option' => $EB8[1]],
    ['id' => 'eb8B',    'titre' => '8e Education de Base B',         'classe' => $EB8[0],  'option' => $EB8[2]],
    ['id' => 'hum1sc',  'titre' => '1re Humanité Scientifique',      'classe' => $hum1[0], 'option' => $hum1[1]],
    ['id' => 'hum1litt','titre' => '1re Humanité Littéraire',        'classe' => $hum1[0], 'option' => $hum1[2]],
    ['id' => 'hum1com', 'titre' => '1re Humanité Commerciale',       'classe' => $hum1[0], 'option' => $hum1[3]],
    ['id' => 'hum2sc',  'titre' => '2e Humanité Scientifique',       'classe' => $hum2[0], 'option' => $hum2[1]],
    ['id' => 'hum2litt','titre' => '2e Humanité Littéraire',         'classe' => $hum2[0], 'option' => $hum2[2]],
    ['id' => 'hum2com', 'titre' => '2e Humanité Commerciale',        'classe' => $hum2[0], 'option' => $hum2[3]],
    ['id' => 'hum3sc',  'titre' => '3e Humanité Scientifique',       'classe' => $hum3[0], 'option' => $hum3[1]],
    ['id' => 'hum3litt','titre' => '3e Humanité Littéraire',         'classe' => $hum3[0], 'option' => $hum3[2]],
    ['id' => 'hum3com', 'titre' => '3e Humanité Commerciale',        'classe' => $hum3[0], 'option' => $hum3[3]],
    ['id' => 'hum4sc',  'titre' => '4e Humanité Scientifique',       'classe' => $hum4[0], 'option' => $hum4[1]],
    ['id' => 'hum4litt','titre' => '4e Humanité Littéraire',         'classe' => $hum4[0], 'option' => $hum4[2]],
    ['id' => 'hum4com', 'titre' => '4e Humanité Commerciale',        'classe' => $hum4[0], 'option' => $hum4[3]],
];
?>

<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="h4 mb-0">Gestion des élèves</h1>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createEdit">
        Créer un élève
    </button>
</div>

<!-- Navigation par classe -->
<nav class="mb-4">
    <ul class="list-group list-group-flush list-group-horizontal flex-wrap text-center">
        <?php foreach ($sections as $s): ?>
        <li class="promo list-group-item">
            <a class="nav-link" href="#<?= $s['id'] ?>"><?= $s['titre'] ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>

<!-- Tables par section -->
<?php foreach ($sections as $s):
    $stmt = $connexion->prepare("SELECT * FROM eleves WHERE classe = ? AND options = ?");
    $stmt->execute([$s['classe'], $s['option']]);
    $lignes = $stmt->fetchAll();
?>
<section class="my-5" id="<?= $s['id'] ?>">
    <h2 class="h5 mb-3"><?= $s['titre'] ?></h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Post-nom</th>
                    <th>Prénom</th>
                    <th>Classe</th>
                    <th>Option</th>
                    <th>categorie</th>
                    <th>Sexe</th>
                    <th>Parent</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lignes as $ligne): ?>
                <tr>
                    <td><?= $ligne['id_eleve'] ?></td>
                    <td><?= htmlspecialchars($ligne['nom']) ?></td>
                    <td><?= htmlspecialchars($ligne['post_nom']) ?></td>
                    <td><?= htmlspecialchars($ligne['prenom']) ?></td>
                    <td><?= htmlspecialchars($ligne['classe']) ?></td>
                    <td><?= htmlspecialchars($ligne['options']) ?></td> 
                    <td><?= htmlspecialchars($ligne['categorie']) ?></td>
                    <td><?= htmlspecialchars($ligne['sexe']) ?></td>
                    <td><?= htmlspecialchars($ligne['id_user'] ?? '') ?></td>
                    <td><?= htmlspecialchars($ligne['statut'] ?? '') ?></td>
                    <td>
                        <a href="?page=students&edit_id=<?= $ligne['id_eleve'] ?>" class="btn btn-primary btn-sm">Editer</a>
                        <form action="" method="post" class="d-inline">
                            <input type="hidden" name="delete_student" value="<?= $ligne['id_eleve'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" name="delete"
                                onclick="return confirm('Supprimer cet élève ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php endforeach; ?>

<!-- MODALE EDITION -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un élève</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    onclick="window.location='dashboard.php?page=students'"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="id_eleve" value="<?= $student_edit['id_eleve'] ?? '' ?>">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control mb-2" value="<?= htmlspecialchars($student_edit['nom'] ?? '') ?>">
                    <label class="form-label">Post-nom</label>
                    <input type="text" name="post_nom" class="form-control mb-2" value="<?= htmlspecialchars($student_edit['post_nom'] ?? '') ?>">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control mb-2" value="<?= htmlspecialchars($student_edit['prenom'] ?? '') ?>">
                    <label class="form-label">Classe</label>
                    <input type="text" name="classe" class="form-control mb-2" value="<?= htmlspecialchars($student_edit['classe'] ?? '') ?>">
                    <label class="form-label">Option</label>
                    <input type="text" name="options" class="form-control mb-2" value="<?= htmlspecialchars($student_edit['options'] ?? '') ?>">
                    <label class="form-label">Categorie</label>
                    <input type="text" name="categorie" class="form-control mb-2" value="<?= htmlspecialchars($student_edit['categorie'] ?? '') ?>">
                    <label class="form-label">Statut</label>
                    <input type="text" name="statut" class="form-control mb-2" value="<?= htmlspecialchars($student_edit['statut'] ?? '') ?>">
                    <label class="form-label">Sexe</label>
                    <input type="text" name="sexe" class="form-control mb-2" value="<?= htmlspecialchars($student_edit['sexe'] ?? '') ?>">
                    <label class="form-label">Parent</label>
                    <select name="parent" class="form-control mb-2" required>
                        <?php 
                            $parent = $connexion->prepare("SELECT id_user FROM users");
                            $parent->execute();
                            $parents = $parent->fetchAll();
                            foreach ($parents as $parent):
                        ?>
                        <option value="<?= $parent['id_user'] ?>">
                            <?= $parent['id_user'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="modifier" class="btn btn-primary w-100">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['edit_id']) && $student_edit): ?>
<script>
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
</script>
<?php endif; ?>

<!-- MODALE CREATION -->
<div class="modal fade" id="createEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créer un élève</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control mb-2" placeholder="Entrez le nom" required>
                    <label class="form-label">Post-nom</label>
                    <input type="text" name="post_nom" class="form-control mb-2" placeholder="Entrez le post-nom" required>
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control mb-2" placeholder="Entrez le prénom" required>
                    <label class="form-label">Classe</label>
                    <select name="classe" class="form-control mb-2" required>
                        <option value="7e">7e</option>
                        <option value="8e">8e</option>
                        <option value="1ère">1ère</option>
                        <option value="2ème">2ème</option>
                        <option value="3ème">3ème</option>
                        <option value="4ème">4ème</option>
                    </select>
                    <label class="form-label">Option</label>
                    <select name="option" class="form-control mb-2" required>
                        <option value="Education de base A">Education de base A</option>
                        <option value="Education de base B">Education de base B</option>
                        <option value="Scientifique">Scientifique</option>
                        <option value="Littéraire">Littéraire</option>
                        <option value="Commerciale">Commerciale</option>
                    </select>
                    <label class="form-label">Categorie</label>
                    <select name="categorie" class="form-control mb-2" required>
                        <option value="ORPUK">ORPUK</option>
                        <option value="Extérieur">Extérieur</option>
                        <option value="Autres">Autres</option>
                    </select>
                    <label class="form-label">Sexe</label>
                    <select name="sexe" class="form-control mb-2" required>
                        <option value="M">M</option>
                        <option value="F">F</option>
                    </select>
                    <label class="form-label">Parent</label>
                    <select name="parent" class="form-control mb-2" required>
                        <?php 
                            $parent = $connexion->prepare("SELECT id_user FROM users");
                            $parent->execute();
                            $parents = $parent->fetchAll();
                            foreach ($parents as $parent):
                        ?>
                        <option value="<?= $parent['id_user'] ?>">
                            <?= $parent['id_user'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="create" class="btn btn-success w-100">Créer</button>
                </form>
            </div>
        </div>
    </div>
</div>