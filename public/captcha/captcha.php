<?php
    session_start();
    header("Content-Type: image/png");
     
    //création de l'image
    $image = imagecreate(250, 75);

    //initialisation des variables
    $background = imagecolorallocate($image, 255, 255, 255);
    $char = "abcdefghijklmnopqrstuvwxyz0123456789";
    $char = str_shuffle($char);
    $length = rand(-8, -6);
    $captcha = substr($char, $length);
    $imgWidth = 250;
    $imgHeight = 75;

    //enregistrement en session du captcha pour la vérification
    $_SESSION['captcha'] = $captcha;

    //gestion des formes géométriques (entre 4 et 10 formes aléatoires)
    for($i = 0; $i < rand(4, 10); $i++)
    {
        //constantes
        $x1 = rand(0, $imgWidth);
        $x2 = rand(0, $imgWidth);
        $y1 = rand(0, $imgHeight);
        $y2 = rand(0, $imgHeight);

        //affectation couleur
        $color = imagecolorallocate($image, rand(150, 250), rand(150, 250), rand(150, 250));
        
        switch(rand(0, 2))
        {
            case 0:
                imageline($image, $x1, $y1, $x2, $y2, $color);
                break;

            case 1:
                imagerectangle($image, $x1, $y1, $x2, $y2, $color);
                break;

            default:
                imageellipse($image, $x1, $y1, $x2, $y2, $color);
                break;
        }
    }

    //tableau des fonts dans le dossier
    $fontsArray = glob(__DIR__.'/fonts/*.ttf');

    //parcours des caractères de la chaîne générée
    for($j = 0; $j < strlen($captcha); $j++)
    {
        //initialisation couleur caractère
        $R2 = rand(0, 255);
        $G2 = rand(0, 255);
        $B2 = rand(0, 255);

        //tant que la couleur du caractère n'est pas assez distincte de la couleur de background on génère une nouvelle couleur
        while(diffColor(255, 255, 255, $R2, $G2, $B2) < 300)
        {
            $R2 = rand(0, 255);
            $G2 = rand(0, 255);
            $B2 = rand(0, 255);
        }

        //initialisation des paramètres de la fonction pour afficher un caractère
        $fontSize = rand(20, 25);
        $angle = rand(-30, 30);
        $x = 10 + $j * 30;
        $y = 35 + rand(0, 15);
        $charColor = imagecolorallocate($image, $R2, $G2, $B2);
        $fontIdx = rand(0, count($fontsArray) - 1);
        $fontFile = $fontsArray[$fontIdx];
        $text = $captcha[$j];

        //ajoute le caractère
        imagettftext($image, $fontSize, $angle, $x, $y, $charColor, $fontFile, $text);
    }

    //affiche l'image
    imagepng($image);

    //permet d'estimer le degré de différence entre deux couleurs (les couleurs sont distinctes si obtention d'un résultat supérieur à 300)
    function diffColor($R1, $G1, $B1, $R2, $G2, $B2)
    {
        return max($R1, $R2) - min($R1, $R2) +
               max($G1, $G2) - min($G1, $G2) +
               max($B1, $B2) - min($B1, $B2);
    }