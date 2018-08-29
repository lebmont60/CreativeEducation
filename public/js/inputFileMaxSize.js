$(document).ready(function()
{
    //fonction déclenchée lors de la sélection d'un fichier dans un formulaire pour comparer la taille du fichier et la taille max autorisée
    $('body').on('change', 'input:file', function()
    {
        //récupération de la taille du fichier
        var fileSize = $(this).prop('files')[0].size;

        //comparaison de la taille en octets (qui équivaut à 5 Mo)
        if(fileSize > 5242880)
        {
            //affichage de l'alert
            addAlert("Le fichier dépasse la taille autorisée", 'error');
            //reset form pour éviter l'envoi du fichier
            $('form')[0].reset();
        }
    });
});