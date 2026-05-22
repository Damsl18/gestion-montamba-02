<?php
require_once 'config.php';

// Nombre d'élèves
$q = $connexion->query("SELECT COUNT(*) FROM eleves");
$nb_eleves = $q->fetchColumn();

// Nombre d'utilisateurs
$q = $connexion->query("SELECT COUNT(*) FROM users");
$nb_users = $q->fetchColumn();

// Nombre de paiements
$q = $connexion->query("SELECT COUNT(*) FROM paiements");
$nb_paiements = $q->fetchColumn();

// Événements à venir (dates futures)
$q = $connexion->query("SELECT COUNT(*) FROM evenements");
$nb_evenements = $q->fetchColumn();

// 5 prochaines dates du calendrier
$q = $connexion->query("SELECT * FROM calendriers ORDER BY dates ASC LIMIT 5");
$prochaines_dates = $q->fetchAll();
?>

<h1 class="h4 mb-4">Tableau de bord</h1>

<!-- Cartes statistiques -->
<div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid var(--color-active) !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:var(--color-active-bg);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-user-graduate" style="color:var(--color-active);font-size:22px;"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size:28px;color:var(--color-active);"><?= $nb_eleves ?></div>
                    <div style="font-size:13px;color:var(--color-muted);">Élèves inscrits</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid var(--color-active) !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:var(--color-active-bg);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-users" style="color:var(--color-active);font-size:22px;"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size:28px;color:var(--color-active);"><?= $nb_users ?></div>
                    <div style="font-size:13px;color:var(--color-muted);">Utilisateurs</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid var(--color-active) !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:var(--color-active-bg);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-money-bill-wave" style="color:var(--color-active);font-size:22px;"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size:28px;color:var(--color-active);"><?= $nb_paiements ?></div>
                    <div style="font-size:13px;color:var(--color-muted);">Paiements</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid var(--color-active) !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:var(--color-active-bg);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-calendar-alt" style="color:var(--color-active);font-size:22px;"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size:28px;color:var(--color-active);"><?= $nb_evenements ?></div>
                    <div style="font-size:13px;color:var(--color-muted);">Événements</div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Prochaines dates du calendrier -->
<div class="card border-0 shadow-sm">
    <div class="card-header" style="background:var(--color-bg-brand);border-bottom:1px solid var(--color-border);">
        <h5 class="mb-0" style="color:var(--color-active);font-size:15px;">
            <i class="fas fa-calendar-week me-2"></i>Prochaines dates du calendrier
        </h5>
    </div>
    <div class="card-body p-0">
        <?php if (empty($prochaines_dates)): ?>
            <p class="text-center p-3" style="color:var(--color-muted);">Aucune date enregistrée.</p>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0 text-center">
                <thead style="background:var(--color-bg-dark);">
                    <tr>
                        <th style="color:var(--color-text);">Jour</th>
                        <th style="color:var(--color-text);">Date</th>
                        <th style="color:var(--color-text);">Événement</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prochaines_dates as $date): ?>
                    <tr>
                        <td><?= htmlspecialchars($date['jour']) ?></td>
                        <td><?= htmlspecialchars($date['dates']) ?></td>
                        <td><?= htmlspecialchars($date['evenement']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>