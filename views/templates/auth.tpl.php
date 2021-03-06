<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Authentification</title>
        <link rel="icon" type="image/png" href="<?php echo DIRNAME; ?>public/images/favicon.png">
        <link rel="stylesheet" type="text/css" href="<?php echo DIRNAME; ?>public/css/main-front.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?php echo DIRNAME; ?>public/js/auth-template.js"></script>
        <script src="<?php echo DIRNAME; ?>public/js/alert.js"></script>
    </head>
    <body>
        <img src="<?php echo DIRNAME; ?>public/images/background-img.jpg" alt="background-image">
        <header>
            <section class="headerTop">
                <div class="logo-container">
                    <img src="<?php echo DIRNAME; ?>public/images/logo.svg" alt="logo">
                    <p>CREATIVE EDUCATION</p>
                </div>
                <nav class="hidden-nav">
                    <ul>
                        <li class="<?php echo ($a == 'registerAction')?'active':''; ?>"><a href="<?php echo DIRNAME; ?>index/register">Inscription<span class="hoverBorder"></span></a></li>
                        <li class="<?php echo ($a == 'loginAction' || $a == 'indexAction')?'active':''; ?>"><a href="<?php echo DIRNAME; ?>index/login">S'identifier<span class="hoverBorder"></span></a></li>
                    </ul>
                </nav>
                <div class="burger-container">
                    <div class="burger">
                        <span class="burger-top"></span>
                        <span class="burger-middle"></span>
                        <span class="burger-bottom"></span>
                    </div>
                </div>
            </section>
        </header>
        <main>
            <section class="main-container">
                <?php
                    include 'views/'.$this->v;
                ?>
            </section>
        </main>
        <footer>
            <?php
                $firstYear = 2018;
                $currentYear = date('Y');
                $message = "© ";

                $message .= ($firstYear < $currentYear)?$firstYear.' - '.$currentYear:$firstYear;
                $message .= ' Créé par <span>Théo Senoussaoui</span>, <span>Julien Roux</span>, <span>Quentin Denisot</span> et <span>Arnaud Bost</span>';

                echo $message;
            ?>
        </footer>
    </body>
</html>