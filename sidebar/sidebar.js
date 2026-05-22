

var sidebar = document.getElementById('sidebar');
var overlay = document.getElementById('overlay');

function ouvrirSidebar() {
  sidebar.classList.add('ouverte');
  overlay.classList.add('visible');
  document.body.style.overflow = 'hidden';
}

function fermerSidebar() {
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

/* Marque le lien actif selon l'URL (?page=…) */
(function() {
  var params = new URLSearchParams(window.location.search);
  var page = params.get('page');
  if (!page) return;

  document.querySelectorAll('.sidebar-link').forEach(function(lien) {
    var href = lien.getAttribute('href');
    if (href && href.indexOf('page=' + page) !== -1) {
      lien.classList.add('active');
    } else {
      lien.classList.remove('active');
    }
  });
})();
