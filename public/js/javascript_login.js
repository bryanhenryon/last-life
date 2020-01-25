// Afficher/Masquer le mot de passe du formulaire de connexion
window.onload = function(){
    var mdp = document.getElementById('mdp');
    var eye = document.getElementById('eye');

    eye.addEventListener('click', myFunction);

    function myFunction(){
        eye.classList.toggle('active');
        (mdp.type == 'password') ? mdp.type = 'text' : mdp.type = 'password';
    }
  }