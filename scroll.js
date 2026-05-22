window.addEventListener('scroll', function(){
    const btn = document.getElementById('scrollTop');
    btn.style.display = window.scrollY > 200 ?  'block' : 'none';
})