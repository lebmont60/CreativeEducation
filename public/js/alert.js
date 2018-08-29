$(document).ready(function()
{
    //récupération de toutes les alerts lors du chargement de la page
    getAlerts();
    //initialisation de la fonction qui permet de supprimer une alert en cliquant sur la croix
    closeAlert();
});

//permet de récupérer toutes les alerts sur la page (générées par la classe alert.php) puis de créer une alert dynamiquement
function getAlerts()
{
    //récupération de toutes les div avec la classe 'alertForJs'
    var alerts = $('.alertForJs');

    //parcours de ces div
    for(var i = 0; i < alerts.length; i++)
    {
        //récupération 
        var alert = $(alerts[i]),
            content = alert.text(),
            type = alert.attr('data-type');

        //timer qui permet de générer les alerts toutes les 0.5 secondes
        setTimeout(function(content, type)
        {
            addAlert(content, type);
        }, i * 500, content, type);
    }
}

//permet de générer une alert
function addAlert(content, type)
{
    //div englobante
    var alertDiv = document.createElement('div');
    $(alertDiv).addClass('alert alert-' + type);

    //span croix
    var alertClose = document.createElement('span');
    $(alertClose).addClass('alertClose');

    alertDiv.append(alertClose);

    //croix pour fermer l'alert
    var close = document.createElement('i');
    $(close).addClass('material-icons');
    $(close).html('close');

    alertClose.append(close);

    //span contenu
    var alertContent = document.createElement('span');
    $(alertContent).addClass('alertContent');
    $(alertContent).text(content);

    alertDiv.append(alertContent);
    
    //vérifie si le container des alerts existe
    if($('#alertsContainer').length)
    {
        //ajout de l'alert dans la div regroupant toutes les alerts
        $('#alertsContainer').append(alertDiv);
    }
    else
    {
        //création du container des alerts
        var alertsContainer = document.createElement('section');
        $(alertsContainer).attr('id', 'alertsContainer');

        //ajout du container dans le DOM
        $('body').append(alertsContainer);

        //ajout de l'alert dans la div regroupant toutes les alerts
        $(alertsContainer).append(alertDiv);
    }

    //animation apparition div
    $(alertDiv).slideDown(500, function()
    {
        //timer qui permet de fermer automatiquement les alerts au bout de 10 secondes
        setTimeout(function()
        {
            closeAlert($(alertDiv));
        }, 10000)
    });
}

//permet de fermer une alert
function closeAlert(myAlertDiv)
{
    //paramètre facultatif donc si undefined -> correspond à l'appel fait dans le $(document).ready() 
    if(typeof myAlertDiv === 'undefined')
    {
        //détruit l'alert avec animation lors du clic sur la croix
        $('body').on('click', '.alertClose', function()
        {
            var alertDiv = $(this).parent()

            $(alertDiv).slideUp(300, function()
            {
                $(alertDiv).remove();
                removeContainer();
            });
        });
    }
    //si le paramètre est spécifié -> correspond à l'appel fait lors de la création de l'alert, pour la fermer au bout de 5 secondes
    else
    {
        $(myAlertDiv).slideUp(300, function()
        {
            $(myAlertDiv).remove();
            removeContainer();
        });
    }
}

//permet de supprimer le container des alerts si toutes les alerts ont été fermées + les div provenant de la classe php
function removeContainer()
{
    if($('#alertsContainer').children().length == 0)
    {
        $('#alertsContainer').remove();
        $('.alertForJs').remove();
    }
}