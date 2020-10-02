function toggleNav() {
    var body = document.body;
    var hamburger = document.getElementById('hamburger_menu');
    var grayBg = document.getElementById('gray_backgroud');
  
    hamburger.addEventListener('click', function() {
        body.classList.toggle('nav-open');
    });
    grayBg.addEventListener('click', function() {
      body.classList.remove('nav-open');
    });
}
  toggleNav();
