<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?php echo DIRNAME; ?>public/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Creative Education</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="<?php echo DIRNAME; ?>public/css/main-back.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo DIRNAME; ?>public/css/alert.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="<?php echo DIRNAME; ?>public/js/alert.js"></script>
    <script src="<?php echo DIRNAME; ?>public/js/inputFileMaxSize.js"></script>
</head>
<body>
    <?php $user = new User(); ?>
    <div class="wrapper">
        <div class="sidebar" data-active-color="rose" data-background-color="black">
            <div class="logo-creative">
                <img src="<?php echo DIRNAME.'public/images/logo.svg'; ?>" alt="logo">
                <a href="<?php echo DIRNAME.'index/home'; ?>" class="simple-text logo-normal">
                    Creative Education
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="<?php echo DIRNAME.$_SESSION['user']['profilePicPath']; ?>">
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>
                                <?php echo Helpers::cleanFirstname($_SESSION['user']['firstname']).' '.Helpers::cleanLastname($_SESSION['user']['lastname']); ?>
                            </span>
                        </a>
                        <div class="clearfix"></div>
                        <div class="collapse" id="collapseExample">
                        </div>
                    </div>
                </div>
                <ul class="nav">
                    <!-- dashboard -->
                    <li class="<?php echo ($a == 'dashboardAction')?'active':''; ?>">
                        <a href="<?php echo DIRNAME.'index/dashboard'; ?>">
                            <i class="material-icons">dashboard</i>
                            <p> Dashboard </p>
                        </a>
                    </li>
                    <!-- utilisateurs -->
                    <li class="<?php echo ($c == 'UserController')?'active':''; ?>">
                        <a data-toggle="collapse" href="#user-menu">
                            <i class="material-icons">supervised_user_circle</i>
                            <p>Utilisateurs<strong class="caret"></strong> </p>
                        </a>
                        <div class="collapse" id="user-menu">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo DIRNAME.'user'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">list</i>
                                        </span>
                                        <span class="sidebar-normal">Liste</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo DIRNAME.'user/add'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">add_circle</i>
                                        </span>
                                        <span class="sidebar-normal">Ajout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- groupes -->
                    <li class="<?php echo ($c == 'UsergroupController')?'active':''; ?>">
                        <a data-toggle="collapse" href="#userGroup-menu">
                            <i class="material-icons">group_work</i>
                            <p>Groupes<strong class="caret"></strong> </p>
                        </a>
                        <div class="collapse" id="userGroup-menu">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo DIRNAME.'usergroup'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">list</i>
                                        </span>
                                        <span class="sidebar-normal">Liste</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo DIRNAME.'usergroup/add'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">add_circle</i>
                                        </span>
                                        <span class="sidebar-normal">Ajout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- cours -->
                    <li class="<?php echo ($c == 'CourseController')?'active':''; ?>">
                        <a data-toggle="collapse" href="#course-menu">
                            <i class="material-icons">class</i>
                            <p>Cours<strong class="caret"></strong> </p>
                        </a>
                        <div class="collapse" id="course-menu">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo DIRNAME.'course'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">list</i>
                                        </span>
                                        <span class="sidebar-normal">Liste</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo DIRNAME.'course/add'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">add_circle</i>
                                        </span>
                                        <span class="sidebar-normal">Ajout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- catégories de cours -->
                    <li class="<?php echo ($c == 'CoursecategoryController')?'active':''; ?>">
                        <a data-toggle="collapse" href="#courseCategory-menu">
                            <i class="material-icons">category</i>
                            <p>Catégories cours<strong class="caret"></strong> </p>
                        </a>
                        <div class="collapse" id="courseCategory-menu">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo DIRNAME.'coursecategory'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">list</i>
                                        </span>
                                        <span class="sidebar-normal">Liste</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo DIRNAME.'coursecategory/add'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">add_circle</i>
                                        </span>
                                        <span class="sidebar-normal">Ajout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- roles -->
                    <?php if($user->isAdmin()): ?>

                        <li class="<?php echo ($c == 'RoleController')?'active':''; ?>">
                            <a data-toggle="collapse" href="#role-menu">
                                <i class="material-icons">assignment</i>
                                <p>Rôles<strong class="caret"></strong> </p>
                            </a>
                            <div class="collapse" id="role-menu">
                                <ul class="nav">
                                    <li>
                                        <a href="<?php echo DIRNAME.'role'; ?>">
                                            <span class="sidebar-mini">
                                                <i class="material-icons">list</i>
                                            </span>
                                            <span class="sidebar-normal">Liste</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo DIRNAME.'role/add'; ?>">
                                            <span class="sidebar-mini">
                                                <i class="material-icons">add_circle</i>
                                            </span>
                                            <span class="sidebar-normal">Ajout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    <?php endif; ?>
                    <!-- pages -->
                    <li class="<?php echo ($c == 'PageController')?'active':''; ?>">
                        <a data-toggle="collapse" href="#page-menu">
                            <i class="material-icons">apps</i>
                            <p>Pages<strong class="caret"></strong> </p>
                        </a>
                        <div class="collapse" id="page-menu">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo DIRNAME.'page'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">list</i>
                                        </span>
                                        <span class="sidebar-normal">Liste</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo DIRNAME.'page/add'; ?>">
                                        <span class="sidebar-mini">
                                            <i class="material-icons">add_circle</i>
                                        </span>
                                        <span class="sidebar-normal">Ajout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- statistiques -->
                    <li>
                        <a href="./charts.html">
                            <i class="material-icons">timeline</i>
                            <p>Statistiques</p>
                        </a>
                    </li>
                    <!-- logout -->
                    <li>
                        <a href="<?php echo DIRNAME.'index/logout'; ?>">
                            <i class="material-icons">exit_to_app</i>
                            <p>Déconnexion</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
            include 'views/'.$this->v;
        ?>
        <!--<footer class="footer">
            <div class="container-fluid">
                <p class="copyright pull-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a href="http://www.theosenoussaoui.fr"> Senoussaoui Théo </a> déteste Charts.js
                </p>
            </div>
        </footer>-->
    </div>
</body>
<!--   Core JS Files   -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo DIRNAME; ?>public/js/creative.js" type="text/javascript"></script>
<script src="<?php echo DIRNAME; ?>public/js/Chart.js" type="text/javascript"></script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            datasets: [{
                label: 'Nombres de pages crées',
                data: [2, 29, 5, 5, 2, 3, 10],
                backgroundColor: "rgba(233,30,99,0.75)"
            }]
        }
    });

</script>

<script>
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            datasets: [{
                label: 'Nombres d\'utilisateurs',
                data: [12, 19, 3, 17, 6, 3, 7],
                backgroundColor: "rgba(233,30,99,0.75)"
            }]
        }
    });

</script>

</html>
