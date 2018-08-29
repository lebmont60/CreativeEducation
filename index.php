<?php 
    session_start();
    require "conf.inc.php";

    function myAutoloader($class)
    {
        if(file_exists("core/".$class.".class.php"))
        {
            include "core/".$class.".class.php";
        }
        elseif(file_exists("models/".$class.".class.php"))
        {
            include "models/".$class.".class.php";
        }
    }

    spl_autoload_register("myAutoloader");

    //affichage des erreurs
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    /*permet de décoder l'url, exemple : /Cours%20PHP/MVC%20v2/user/add?id=2 -> /Cours PHP/MVC v2/user/add?id=2
      et de récupérer la partie /user/add?id=2 si elle est présente*/
      
    //$uri = str_ireplace(DIRNAME, "", urldecode($_SERVER["REQUEST_URI"]));

    $uri = substr(urldecode($_SERVER['REQUEST_URI']), strlen(dirname($_SERVER['SCRIPT_NAME'])));

    //permet de supprimer le premier '/' dans la chaîne
    $uri = ltrim($uri, '/');

    //suppression des variables de type ?=xxxxx
    $uri = explode("?", $uri);

    //permet de récupérer le contrôleur et l'action dans l'url
    $uriExploded = explode("/", $uri[0]);

    //"index" si la clé n'existe pas, c'est à dire s'il n'y a ni contrôlleur ni action dans l'url :
    $c = (empty($uriExploded[0])) ? "index" : $uriExploded[0];
    $a = (empty($uriExploded[1])) ? "index" : $uriExploded[1];

    //si l'action est un nombre on place un underscore devant juste devant (pour $a = '404', l'action = '_404Action' -> norme de nommage des fonctions php)
    $a = (is_numeric(substr($a, 0, 1))) ? '_'.$a : $a;

    //Controller : NomController
    $c = ucfirst(strtolower($c))."Controller";

    //Action : nomAction
    $a = strtolower($a)."Action";

    //permet de vider les variables "inutiles"
    unset($uriExploded[0]);
    unset($uriExploded[1]);

    $uriExploded = array_values($uriExploded);

    $params = [
        "POST" => $_POST,
        "GET" => $_GET,
        "FILES" => $_FILES,
        "URL" => $uriExploded
    ];

    //vérification de l'existence du fichier
    if(file_exists("controllers/".$c.".class.php"))
    {
        include "controllers/".$c.".class.php";

        //vérification de l'existence de la classe
        if(class_exists($c))
        {
            $objC = new $c();

            //vérification de l'existence de la méthode
            if(method_exists($objC, $a))
            {
                $objC->$a($params);
            }
            else
            {
                //die("L'action ".$a." n'existe pas.");
                header('Location: '.DIRNAME.'error/404');
            }
        }
        else
        {
            //die("Le contrôleur ".$c." n'existe pas.");
            header('Location: '.DIRNAME.'error/404');
        }
    }
    else
    {
        //die("Le fichier ".$c." n'existe pas.");
        header('Location: '.DIRNAME.'error/404');
    }