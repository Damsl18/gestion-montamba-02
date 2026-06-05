/* ── Hamburger menu ── */
var sidebar = document.getElementById('sidebar');
var overlay = document.getElementById('overlay');

function ouvrirSidebar() {
  if (!sidebar || !overlay) return; /* BUG FIXÉ : null guard si éléments absents */
  sidebar.classList.add('ouverte');
  overlay.classList.add('visible');
  document.body.style.overflow = 'hidden';
}

function fermerSidebar() {
  if (!sidebar || !overlay) return;
  sidebar.classList.remove('ouverte');
  overlay.classList.remove('visible');
  document.body.style.overflow = '';
}

/* Ferme la sidebar au clic sur un lien (mobile) */
document.querySelectorAll('.sidebar-link').forEach(function(lien) {
  lien.addEventListener('click', function() {
    if (window.innerWidth < 992) {
      fermerSidebar();
    }
  });
});

(function() {
  var params = new URLSearchParams(window.location.search);
  var page = params.get('page') || 'dashboard';

  document.querySelectorAll('.sidebar-link').forEach(function(lien) {
    var href = lien.getAttribute('href') || '';
    if (href.indexOf('page=' + page) !== -1) {
      lien.classList.add('active');
    } else {
      lien.classList.remove('active');
    }
  });
})();
