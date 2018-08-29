<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Front Homepage</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" href="<?php echo DIRNAME; ?>public/images/favicon.png">

    <!-- chargement du css en fonction de la page sur laquelle on se trouve -->

    <?php if($a == 'homeAction'): ?>
    <link rel="stylesheet" type="text/css" href="<?php echo DIRNAME; ?>public/css/style-front-tpl-home.css">

    <?php else: ?>
    <link rel="stylesheet" type="text/css" href="<?php echo DIRNAME; ?>public/css/style-front-tpl.css">


    <?php endif; ?>

    <link rel="stylesheet" type="text/css" href="<?php echo DIRNAME; ?>public/css/main-back.css">
    <link rel="stylesheet" type="text/css" href="<?php echo DIRNAME; ?>public/css/alert.css">

    <script src="<?php echo DIRNAME; ?>public/js/alert.js"></script>
</head>

<body>
    <header>
        <img src="<?php echo DIRNAME; ?>public/images/background-img.jpg" alt="background-image">
        <div class="headerTop">
            <div class="logo-container">
                <img src="<?php echo DIRNAME; ?>public/images/logo.svg" alt="logo">
                <p>CREATIVE EDUCATION</p>
            </div>
            <nav class="hidden-nav">
                <ul>
                    <li class="active"><a href="#onglet1">Accueil<span class="hoverBorder"></span></a></li>
                    <li class="item-list">
                        <a href="#onglet2">Mes cours<img src="<?php echo DIRNAME; ?>public/images/arrow-down.svg" alt="arrow-down" class="dropdown-arrow"><span class="hoverBorder"></span></a>
                        <div class="dropdown-container">
                            <div class="triangle"></div>
                                <ul class="dropdown-list hidden-dropdown">
                                    <?php 
                                        $arrayCategories = Helpers::listCourseCategoryTableDropdown();
                                                var_dump($arrayCategories);

                                        foreach ($arrayCategories as $keys => $value){
                                            echo '<li><a href="#onglet2-item1">'.$value.'</a></li>';
                                        }
                                    ?>
                                </ul>
                        </div>
                    </li>
                    <li class="navbar-right">
                        <form method="POST" action="<?php echo DIRNAME.'index/logout';?>">
                            <button name="button" class="btn btn-red">
                                déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
            <div class="burger-container">
                <div class="burger">
                    <span class="burger-top"></span>
                    <span class="burger-middle"></span>
                    <span class="burger-bottom"></span>
                </div>
            </div>
        </div>

        <!-- affichage ou non de l'élément en fonction de la page sur laquelle on se trouve -->

        <?php if($a == 'homeAction'): ?>

        <section class="headerBottom">
            <div>Bienvenue,
                <?php echo ucfirst(mb_strtolower($this->data['name'])); ?>.</div>
        </section>

        <?php endif; ?>

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

<script>
    //Set tooltip's triangle right position
    function setTrianglePosition() {
        var nbChildren = $('nav > ul').children('li').length;

        for (var i = 0; i < nbChildren; i++) {
            var li = $('nav > ul').children('li:eq(' + i + ')');

            if (li.hasClass('item-list')) {
                var liWidth = li.children('a').outerWidth();
                var dropdownWidth = li.children('div.dropdown-container').outerWidth();
                //on divise par 2 car la différence de taille entre les deux éléments se fait à gauche et à droite du <a> (car .dropdown-container est centré) 
                //on soustrait de 2px simplement pour ajuster l'alignement entre le triangle et la flèche déroulante
                var rightPosition = ((dropdownWidth - liWidth) / 2) - 2;

                if (rightPosition >= 0) {
                    li.children('div.dropdown-container').children('div.triangle').css('right', Math.round(rightPosition));
                } else {
                    li.children('div.dropdown-container').children('div.triangle').css('right', '50%');
                    li.children('div.dropdown-container').children('div.triangle').css('transform', 'translateX(50%)');
                }

                console.log(liWidth);
                console.log(dropdownWidth);
                console.log(rightPosition);
            }
        }
    }

    //Fixed footer on bottom
    function setFooter() {
        var footer = $('footer');
        var offset = footer.offset();
        var windowHeight = $(window).height();

        if ((offset.top + footer.height()) < windowHeight) {
            footer.css('position', 'absolute');
            footer.css('bottom', '0px');
            footer.css('width', '-webkit-fill-available');
        }
    }

    $(document).ready(function() {
        //Calls function on page load
        setTrianglePosition();

        //Calls function on page load
        setFooter();

        //Calls function on page resizing
        $(window).resize(function() {
            setFooter();
        });

        //Sidebar open + burger menu icon animation
        $('.burger').click(function() {
            var nav = $('nav');
            var burgerTop = $('.burger-top');
            var burgerMiddle = $('.burger-middle');
            var burgerBottom = $('.burger-bottom');

            if (nav.hasClass('hidden-nav')) {
                burgerTop.addClass('animation-top');
                burgerMiddle.addClass('animation-middle');
                burgerBottom.addClass('animation-bottom');
                nav.removeClass('hidden-nav');
                nav.addClass('visible-nav');
            } else {
                burgerTop.removeClass('animation-top');
                burgerMiddle.removeClass('animation-middle');
                burgerBottom.removeClass('animation-bottom');
                nav.removeClass('visible-nav');
                nav.addClass('hidden-nav');
            }
        });

        //Expands submenu on item menu click
        $('.item-list').click(function() {
            var img = $(this).find('.dropdown-arrow');

            if ($(this).find('.dropdown-list').hasClass('hidden-dropdown')) {
                img.addClass('dropdown-arrow-reversed');
                $(this).find('.dropdown-list').removeClass('hidden-dropdown');
                $(this).find('.dropdown-list').addClass('visible-dropdown');
            } else {
                img.removeClass('dropdown-arrow-reversed');
                $(this).find('.dropdown-list').removeClass('visible-dropdown');
                $(this).find('.dropdown-list').addClass('hidden-dropdown');
            }
        });

        $('.dropdown-list').click(function(e) {
            e.stopPropagation();
        });
    });

</script>
