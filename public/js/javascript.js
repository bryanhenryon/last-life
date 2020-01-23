// Menu burger
const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links-mobile');
    const navLinks = document.querySelectorAll('.nav-links-mobile li');
    // Toggle Nav
    burger.addEventListener('click',()=>{
     nav.classList.toggle('nav-active');

    //Animate Links
    navLinks.forEach((link, index)=>{
        if(link.style.animation){
            link.style.animation = ''
        } else{
            link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
        }
    });
    // Burger Animation
    burger.classList.toggle('toggle');
    });
}

navSlide();

// Afficher le nom du fichier selectionné dans un input de type "file"
$('#account_file').on('change',function(){
    // Récupérer le nom du fichier selectionné puis filtrer grâce à une imitation de regex de sorte à masquer son chemin d'accès
    var fileName = $(this).val().replace(/.*[\/\\]/, '');

    // Afficher le nom du fichier dans le label de l'input
    $(this).next('.custom-file-label').html(fileName);
})

// Scroll back to top button fade in and out
if($(window).width() >= 1024){
    $(document).ready(function(){ 
        $(window).scroll(function(){ 
            if ($(this).scrollTop() > 700) { 
                $('#scrollBackToTop').fadeIn(); 
            } else { 
                $('#scrollBackToTop').fadeOut(); 
            } 
        }); 
        
        $('#scrollBackToTop').click(function(){ 
            $("html, body").animate({ scrollTop: 0 }, 600); 
            return false; 
        }); 
    });
}