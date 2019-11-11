// AFFICHER LE NOM DU FICHIER SELECTIONNÉ DANS UN INPUT TYPE="FILE"

$('#article_file, #article_fileun, #article_filedeux').on('change',function(){
    // Récupérer le nom du fichier selectionné puis filtrer grâce à une imitation de regex de sorte à masquer son chemin d'accès
    var fileName = $(this).val().replace(/.*[\/\\]/, '');

    // Afficher le nom du fichier dans le label de l'input
    $(this).next('.custom-file-label').html(fileName);
})