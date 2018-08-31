<?php
    class IndexController
    {
        public function indexAction($params)
        {
            //si session existante on renvoie vers la page d'accueil
            if(isset($_SESSION['user']))
            {
                /*$v = new View("front-home", "front");
                $v->assign('name', $_SESSION['user']['firstname']);*/
                header('Location: '.DIRNAME.'index/home');
            }
            //sinon affichage page login
            else
            {
                /*$form = Auth::loginForm();
                $v = new View("auth-login", "auth");
                $v->assign("config", $form);
                $v->assign("errors", '');
                $v->assign("fieldValues", null);*/
                header('Location: '.DIRNAME.'index/login');
            }
        }

        public function loginAction($params)
        {
            $user = new User();

            //si utilisateur connecté
            if($user->isConnected())
            {
                //si role autorisé on renvoie vers la page d'accueil
                if($user->allowedRole())
                {
                    header('Location: '.DIRNAME.'index/home');
                }
                //sinon déconnexion
                else
                {
                    header('Location: '.DIRNAME.'index/logout');
                }
            }
            //sinon affichage page login
            else
            {
                //si tous les champs sont remplis
                if(!empty($params['POST']))
                {
                    //récupération user via email
                    $queryConditions = [
                        "select"=>[
                            "user.*"
                        ],
                        "join"=>[
                            "inner_join"=>[],
                            "left_join"=>[],
                            "right_join"=>[]
                        ],
                        "where"=>[
                            "clause"=>"LOWER(user.email) = '".strtolower($params['POST']['email'])."'",
                            "and"=>[],
                            "or"=>[]
                        ],
                        "and"=>[
                            [
                                "clause"=>"",
                                "and"=>[],
                                "or"=>[]
                            ]
                        ],
                        "or"=>[
                            [
                                "clause"=>"",
                                "and"=>[],
                                "or"=>[]
                            ]
                        ],
                        "group_by"=>[],
                        "having"=>[
                            "clause"=>"",
                            "and"=>[],
                            "or"=>[]
                        ],
                        "order_by"=>[
                            "asc"=>[],
                            "desc"=>[]
                        ],
                        "limit"=>[
                            "offset"=>"",
                            "range"=>""
                        ]
                    ];

                    $user = new User();
                    $targetedUser = $user->getAll($queryConditions);

                    //si l'utilisateur est trouvé
                    if(count($targetedUser) == 1)
                    {
                        //si l'utilisateur n'est pas désactivé
                        if(!$user->isDeactivated($targetedUser[0]->getId()))
                        {
                            //si le mot de passe est correct
                            if(password_verify($params['POST']['password'], $targetedUser[0]->getPwd()))
                            {
                                //si le rôle de l'utilisateur n'est pas "en attente de validation mail" : on continue la vérification
                                if($targetedUser[0]->getId_role() != 5)
                                {
                                    //si le rôle de l'utilisateur n'est pas "en attente d'attribution de rôle" : connexion
                                    if($targetedUser[0]->getId_role() != 3)
                                    {
                                        //mise à jour token bdd de l'utilisateur
                                        $targetedUser[0]->setToken();
                                        $targetedUser[0]->save();

                                        $_SESSION['user']['id'] = $targetedUser[0]->getId();
                                        $_SESSION['user']['firstname'] = $targetedUser[0]->getFirstname();
                                        $_SESSION['user']['lastname'] = $targetedUser[0]->getLastname();
                                        $_SESSION['user']['email'] = $targetedUser[0]->getEmail();
                                        $_SESSION['user']['status'] = $targetedUser[0]->getStatus();
                                        $_SESSION['user']['token'] = $targetedUser[0]->getToken();
                                        $_SESSION['user']['profilePicPath'] = $targetedUser[0]->getProfilePicPath();
                                        $_SESSION['user']['insertedDate'] = $targetedUser[0]->getInsertedDate();
                                        $_SESSION['user']['updatedDate'] = $targetedUser[0]->getUpdatedDate();
                                        $_SESSION['user']['id_role'] = $targetedUser[0]->getId_role();

                                        //redirection vers le dashboard pour l'admin et les professeurs
                                        if($user->isAdmin() || $user->isProfessor())
                                        {
                                            header('Location: '.DIRNAME.'index/dashboard');
                                        }
                                        //redirection vers la page d'accueil pour les apprenants
                                        elseif($user->isStudent())
                                        {
                                            header('Location: '.DIRNAME.'index/home');
                                        }
                                    }
                                    //affichage message erreur
                                    else
                                    {
                                        $form = Auth::loginForm();
                                        $v = new View("auth-login", "auth");
                                        $v->assign("config", $form);
                                        $v->assign("errors", "Compte en attente d'attribution de rôle");
                                        //on ne réaffiche pas le mot de passe
                                        unset($params['POST']['password']);
                                        $v->assign("fieldValues", $params['POST']);
                                        $alert = new Alert("Compte en attente d'attribution de rôle", 'info');
                                    }
                                }
                                //affichage message erreur
                                else
                                {
                                    $form = Auth::loginForm();
                                    $v = new View("auth-login", "auth");
                                    $v->assign("config", $form);
                                    $v->assign("errors", "Compte en attente de validation mail");
                                    //on ne réaffiche pas le mot de passe
                                    unset($params['POST']['password']);
                                    $v->assign("fieldValues", $params['POST']);
                                    $alert = new Alert('Compte en attente de validation mail', 'info');
                                }
                                
                            }
                            //sinon affichage message erreur
                            else
                            {
                                $form = Auth::loginForm();
                                $v = new View("auth-login", "auth");
                                $v->assign("config", $form);
                                $v->assign("errors", "Identifiants incorrects, veuillez réessayer");
                                //on ne réaffiche pas le mot de passe
                                unset($params['POST']['password']);
                                $v->assign("fieldValues", $params['POST']);
                                $alert = new Alert('Identifiants incorrects, veuillez réessayer', 'error');
                            }
                        }
                        //sinon erreur : user désactivé
                        else
                        {
                            $form = Auth::loginForm();
                            $v = new View("auth-login", "auth");
                            $v->assign("config", $form);
                            $v->assign("errors", "Votre compte est désactivé");
                            //on ne réaffiche pas le mot de passe
                            unset($params['POST']['password']);
                            $v->assign("fieldValues", $params['POST']);
                            $alert = new Alert('Votre compte est désactivé', 'info');
                        }
                    }
                    //sinon erreur : utilisateur inexistant
                    else
                    {
                        $form = Auth::loginForm();
                        $v = new View("auth-login", "auth");
                        $v->assign("config", $form);
                        $v->assign("errors", "Utilisateur inexistant");
                        //on ne réaffiche pas le mot de passe
                        unset($params['POST']['password']);
                        $v->assign("fieldValues", $params['POST']);
                        $alert = new Alert('Utilisateur inexistant', 'info');
                    }
                }
                //si aucun champ n'est envoyé via post (accès à la page pour la 1ère fois)
                else
                {
                    $form = Auth::loginForm();
                    $v = new View("auth-login", "auth");
                    $v->assign("config", $form);
                    $v->assign("errors", '');
                    $v->assign("fieldValues", null);
                }
            }
        }

        public function registerAction($params)
        {
            $user = new User();

            //si utilisateur connecté
            if($user->isConnected())
            {
                //si role autorisé on renvoie vers la page d'accueil
                if($user->allowedRole())
                {
                    header('Location: '.DIRNAME.'index/home');
                }
                //sinon déconnexion
                else
                {
                    header('Location: '.DIRNAME.'index/logout');
                }
            }
            //sinon affichage page register
            else
            {
                //si tous les champs sont remplis
                if(!empty($params['POST']))
                {
                    $form = Auth::registerForm();
                    $errors = Validator::validate($form, $params['POST']);

                    //s'il y a des erreurs avec les données saisies dans le formulaire on les affiche
                    if(!empty($errors))
                    {
                        $v = new View("auth-register", "auth");
                        $v->assign("config", $form);
                        $v->assign("errors", $errors);
                        $v->assign("fieldValues", $params['POST']);

                        //alerts
                        foreach($errors as $error)
                        {
                            $alert = new Alert($error, 'error');
                        }
                    }
                    //sinon on renvoie sur la même page avec message de succès + on enregistre l'utilisateur
                    else
                    {
                        //vérification existence adresse mail
                        $queryConditions = [
                            "select"=>[
                                "user.*"
                            ],
                            "join"=>[
                                "inner_join"=>[],
                                "left_join"=>[],
                                "right_join"=>[]
                            ],
                            "where"=>[
                                "clause"=>"LOWER(user.email) = '".strtolower($params['POST']['email'])."'",
                                "and"=>[],
                                "or"=>[]
                            ],
                            "and"=>[
                                [
                                    "clause"=>"",
                                    "and"=>[],
                                    "or"=>[]
                                ]
                            ],
                            "or"=>[
                                [
                                    "clause"=>"",
                                    "and"=>[],
                                    "or"=>[]
                                ]
                            ],
                            "group_by"=>[],
                            "having"=>[
                                "clause"=>"",
                                "and"=>[],
                                "or"=>[]
                            ],
                            "order_by"=>[
                                "asc"=>[],
                                "desc"=>[]
                            ],
                            "limit"=>[
                                "offset"=>"",
                                "range"=>""
                            ]
                        ];

                        $user = new User();
                        $targetedUser = $user->getAll($queryConditions);

                        //si l'adresse email est déjà utilisée : erreur
                        if(count($targetedUser) == 1)
                        {
                            $form = Auth::registerForm();
                            $v = new View("auth-register", "auth");
                            $v->assign("config", $form);
                            $v->assign("errors", "Adresse mail déjà utilisée");
                            $v->assign("fieldValues", $params['POST']);
                            $alert = new Alert("Adresse mail déjà utilisée", 'error');
                        }
                        //sinon succès
                        else
                        {
                            $form = Auth::registerForm();
                            $v = new View("auth-register", "auth");
                            $v->assign("config", $form);
                            $v->assign("errors", "Inscription terminée, veuillez consulter vos mails");
                            $v->assign("fieldValues", $params['POST']);
                            $alert = new Alert("Inscription terminée, veuillez consulter vos mails", 'success');

                            $user = new User();
                            $user->setFirstname($params['POST']['firstname']);
                            $user->setLastname($params['POST']['lastname']);
                            $user->setPwd($params['POST']['password']);
                            $user->setemail($params['POST']['email']);
                            $user->setStatus('1');
                            $user->setToken();
                            $user->setId_role('5');
                            $user->setId_user_group('1');
                            $user->save();

                            //récupération de l'id du user depuis email
                            $queryConditions = [
                                "select"=>[
                                    "user.*"
                                ],
                                "join"=>[
                                    "inner_join"=>[],
                                    "left_join"=>[],
                                    "right_join"=>[]
                                ],
                                "where"=>[
                                    "clause"=>"LOWER(user.email) = '".strtolower($params['POST']['email'])."'",
                                    "and"=>[],
                                    "or"=>[]
                                ],
                                "and"=>[
                                    [
                                        "clause"=>"",
                                        "and"=>[],
                                        "or"=>[]
                                    ]
                                ],
                                "or"=>[
                                    [
                                        "clause"=>"",
                                        "and"=>[],
                                        "or"=>[]
                                    ]
                                ],
                                "group_by"=>[],
                                "having"=>[
                                    "clause"=>"",
                                    "and"=>[],
                                    "or"=>[]
                                ],
                                "order_by"=>[
                                    "asc"=>[],
                                    "desc"=>[]
                                ],
                                "limit"=>[
                                    "offset"=>"",
                                    "range"=>""
                                ]
                            ];

                            $idUser = new User();
                            $targetedUser = $idUser->getAll($queryConditions)[0];

                            //création de l'url sur laquelle on va être renvoyé en cliquant sur le bouton dans le mail (action + id du user + son token)
                            $url = SERVERNAME.DIRNAME.'index/validateMail/'.$targetedUser->getId().'/'.$user->getToken();

                            //récupération du fichier 
                            $content = file_get_contents('views/mail.php');

                            //remplacement de la chaine pour l'url de redirection
                            $content = str_replace('{%%url%%}', $url, $content);

                            //envoi de mail
                            $user->sendMail('Validation de votre compte CreativeEducation', $content);
                        }
                    }
                }
                //si aucun champ n'est envoyé via post (accès à la page pour la 1ère fois)
                else
                {
                    $form = Auth::registerForm();
                    $v = new View("auth-register", "auth");
                    $v->assign("config", $form);
                    $v->assign("errors", '');
                    $v->assign("fieldValues", null);
                }
            }
        }

        public function logoutAction($params)
        {
            //si session existante on détruit la session
            if(isset($_SESSION['user']))
            {
                session_unset();
                session_destroy();
            }

            //on renvoie vers la page de login, que l'utilisateur soit connecté ou non
            header('Location: '.DIRNAME.'index/login');
        }

        public function homeAction($params)
        {
            $user = new User();

            //si utilisateur connecté on renvoie vers la page d'accueil
            if($user->isConnected())
            {
                if($user->allowedRole())
                {

                    $v = new View("front-home", "front");
                    $v->assign('name', $_SESSION['user']['firstname']);
                }
                //sinon déconnexion
                else
                {
                    header('Location: '.DIRNAME.'index/logout');
                }
            }
            //sinon on renvoie vers la page de login
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }

        public function dashboardAction($params)
        {
            $user = new User();

            //si utilisateur connecté on renvoie vers la page d'accueil
            if($user->isConnected() && ($user->isAdmin() || $user->isProfessor()))
            {
                $studentsList = $user->listStudentsDashTable();
                $professorsList = $user->listProfessorsDashTable();
                $v = new View('back-dashboard', 'back');
                $v->assign('studentsList', $studentsList);
                $v->assign('professorsList', $professorsList);
            }
            //sinon on renvoie vers la page de login
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }

        public function validateMailAction($params)
        {
            $idUser = $params['URL'][0];
            $token = $params['URL'][1];

            //si les paramètres sont passés dans l'url, on continue
            if(!empty($idUser) && !empty($token))
            {
                //récupération user
                $queryConditions = [
                    "select"=>[
                        "`user`.*"
                    ],
                    "join"=>[
                        "inner_join"=>[],
                        "left_join"=>[],
                        "right_join"=>[]
                    ],
                    "where"=>[
                        "clause"=>"`user`.`id` = ".$idUser,
                        "and"=>[],
                        "or"=>[]
                    ],
                    "and"=>[
                        [
                            "clause"=>"",
                            "and"=>[],
                            "or"=>[]
                        ]
                    ],
                    "or"=>[
                        [
                            "clause"=>"",
                            "and"=>[],
                            "or"=>[]
                        ]
                    ],
                    "group_by"=>[],
                    "having"=>[
                        "clause"=>"",
                        "and"=>[],
                        "or"=>[]
                    ],
                    "order_by"=>[
                        "asc"=>[],
                        "desc"=>[]
                    ],
                    "limit"=>[
                        "offset"=>"",
                        "range"=>""
                    ]
                ];

                $user = new User();
                $targetedUser = $user->getAll($queryConditions);

                //si user trouvé, on continue
                if(count($targetedUser) == 1)
                {
                    //vérification que le user ait bien le rôle "en attente de validation mail"
                    if($targetedUser[0]->getId_role() == 5)
                    {
                        //vérification correspondance token
                        if($targetedUser[0]->getToken() == $token)
                        {
                            //on change le rôle du user, il passe à "en attente de validation de rôle"
                            $targetedUser[0]->setId_role(3);
                            $targetedUser[0]->save();

                            //echo 'Vérification mail effectuée avec succès';
                            //on renvoie vers la page de login, que l'utilisateur soit connecté ou non

                            $form = Auth::loginForm();
                            $v = new View("auth-login", "auth");
                            $v->assign("config", $form);
                            $v->assign("errors", '');
                            $v->assign("fieldValues", null);

                            $alert = new Alert("Validation effectuée avec succès", 'success');
                            $alert = new Alert("Vous aurez bientôt accès à la plateforme", 'success');
                        }
                        //redirection sur la page de login si token pas correspondant
                        else
                        {
                            //bouton pour renvoyer un mail de confirmation
                            header('Location: '.DIRNAME.'index/login');
                        }
                    }
                    //redirection sur la page de login si pas le bon rôle
                    else
                    {
                        header('Location: '.DIRNAME.'index/login');
                    }
                }
                //retour sur la page de login si aucun user correspondant
                else
                {
                    header('Location: '.DIRNAME.'index/login');
                }
            }
            //retour sur la page de login si les paramètres ne sont pas tous renseignés
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }

        public function forgottenPasswordAction($params)
        {
            //si tous les champs sont remplis
            if(!empty($params['POST']))
            {
                $form = Auth::forgottenPasswordForm();
                $errors = Validator::validate($form, $params['POST']);

                //s'il y a des erreurs avec les données saisies dans le formulaire on les affiche
                if(!empty($errors))
                {
                    $v = new View("auth-forgottenPassword", "auth");
                    $v->assign("config", $form);
                    $v->assign("errors", $errors);
                    $v->assign("fieldValues", $params['POST']);

                    //alerts
                    foreach($errors as $error)
                    {
                        $alert = new Alert($error, 'error');
                    }
                }
                //sinon on renvoie sur la même page avec message de succès + on envoie le mail de renouvellement du mdp (si compte existant)
                else
                {
                    //vérification existence adresse mail
                    $queryConditions = [
                        "select"=>[
                            "user.*"
                        ],
                        "join"=>[
                            "inner_join"=>[],
                            "left_join"=>[],
                            "right_join"=>[]
                        ],
                        "where"=>[
                            "clause"=>"LOWER(user.email) = '".strtolower($params['POST']['email'])."'",
                            "and"=>[],
                            "or"=>[]
                        ],
                        "and"=>[
                            [
                                "clause"=>"",
                                "and"=>[],
                                "or"=>[]
                            ]
                        ],
                        "or"=>[
                            [
                                "clause"=>"",
                                "and"=>[],
                                "or"=>[]
                            ]
                        ],
                        "group_by"=>[],
                        "having"=>[
                            "clause"=>"",
                            "and"=>[],
                            "or"=>[]
                        ],
                        "order_by"=>[
                            "asc"=>[],
                            "desc"=>[]
                        ],
                        "limit"=>[
                            "offset"=>"",
                            "range"=>""
                        ]
                    ];

                    $user = new User();
                    $targetedUser = $user->getAll($queryConditions);

                    //si l'adresse mail existe on peut envoyer le mail de renouvellement
                    if(count($targetedUser) == 1)
                    {
                        $form = Auth::forgottenPasswordForm();
                        $v = new View("auth-forgottenPassword", "auth");
                        $v->assign("config", $form);
                        $v->assign("errors", "Mail de renouvellement envoyé avec succès");
                        $v->assign("fieldValues", $params['POST']);
                        $alert = new Alert("Mail de renouvellement envoyé avec succès", 'success');

                        //récupération de l'id du user depuis email
                        $queryConditions = [
                            "select"=>[
                                "user.*"
                            ],
                            "join"=>[
                                "inner_join"=>[],
                                "left_join"=>[],
                                "right_join"=>[]
                            ],
                            "where"=>[
                                "clause"=>"LOWER(user.email) = '".strtolower($params['POST']['email'])."'",
                                "and"=>[],
                                "or"=>[]
                            ],
                            "and"=>[
                                [
                                    "clause"=>"",
                                    "and"=>[],
                                    "or"=>[]
                                ]
                            ],
                            "or"=>[
                                [
                                    "clause"=>"",
                                    "and"=>[],
                                    "or"=>[]
                                ]
                            ],
                            "group_by"=>[],
                            "having"=>[
                                "clause"=>"",
                                "and"=>[],
                                "or"=>[]
                            ],
                            "order_by"=>[
                                "asc"=>[],
                                "desc"=>[]
                            ],
                            "limit"=>[
                                "offset"=>"",
                                "range"=>""
                            ]
                        ];

                        $user = new User();
                        $targetedUser = $user->getAll($queryConditions)[0];

                        //création de l'url sur laquelle on va être renvoyé en cliquant sur le bouton dans le mail (action + id du user + son token)
                        $url = SERVERNAME.DIRNAME.'index/renewPassword/'.$targetedUser->getId().'/'.$targetedUser->getToken();

                        //récupération du fichier 
                        $content = file_get_contents('views/mail-renew-pwd.php');

                        //remplacement de la chaine pour l'url de redirection
                        $content = str_replace('{%%url%%}', $url, $content);

                        //envoi de mail
                        $targetedUser->sendMail('Renouvellement de votre mot de passe sur CreativeEducation', $content);
                    }
                    //si l'adresse email n'existe pas : on ne peut pas renouveler le mail d'un compte inexisant, donc erreur
                    else
                    {
                        $form = Auth::forgottenPasswordForm();
                        $v = new View("auth-forgottenPassword", "auth");
                        $v->assign("config", $form);
                        $v->assign("errors", "Compte inexistant");
                        $v->assign("fieldValues", $params['POST']);
                        $alert = new Alert("Compte inexistant", 'error');
                    }
                }
            }
            //si aucun champ n'est envoyé via post (accès à la page pour la 1ère fois)
            else
            {
                $form = Auth::forgottenPasswordForm();
                $v = new View("auth-forgottenPassword", "auth");
                $v->assign("config", $form);
                $v->assign("errors", '');
                $v->assign("fieldValues", null);
            }
        }

        public function renewPasswordAction($params)
        {
            $idUser = $params['URL'][0];
            $token = $params['URL'][1];

            //si les paramètres sont passés dans l'url, on continue
            if(!empty($idUser) && !empty($token))
            {
                //récupération user
                $queryConditions = [
                    "select"=>[
                        "`user`.*"
                    ],
                    "join"=>[
                        "inner_join"=>[],
                        "left_join"=>[],
                        "right_join"=>[]
                    ],
                    "where"=>[
                        "clause"=>"`user`.`id` = ".$idUser,
                        "and"=>[],
                        "or"=>[]
                    ],
                    "and"=>[
                        [
                            "clause"=>"",
                            "and"=>[],
                            "or"=>[]
                        ]
                    ],
                    "or"=>[
                        [
                            "clause"=>"",
                            "and"=>[],
                            "or"=>[]
                        ]
                    ],
                    "group_by"=>[],
                    "having"=>[
                        "clause"=>"",
                        "and"=>[],
                        "or"=>[]
                    ],
                    "order_by"=>[
                        "asc"=>[],
                        "desc"=>[]
                    ],
                    "limit"=>[
                        "offset"=>"",
                        "range"=>""
                    ]
                ];

                $user = new User();
                $targetedUser = $user->getAll($queryConditions);

                //si user trouvé, on continue
                if(count($targetedUser) == 1)
                {
                    //vérification correspondance token
                    if($targetedUser[0]->getToken() == $token)
                    {
                        //si tous les champs sont remplis
                        if(!empty($params['POST']))
                        {
                            $form = Auth::renewPasswordForm();
                            $errors = Validator::validate($form, $params['POST']);

                            //s'il y a des erreurs avec les données saisies dans le formulaire on les affiche
                            if(!empty($errors))
                            {
                                $v = new View("auth-renewPassword", "auth");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $params['POST']);

                                //alerts
                                foreach($errors as $error)
                                {
                                    $alert = new Alert($error, 'error');
                                }
                            }
                            //sinon on renvoie sur la même page avec message de succès + enregistrement nouveau mot de passe de l'utilisateur + màj token
                            else
                            {
                                $form = Auth::loginForm();
                                $v = new View("auth-login", "auth");
                                $v->assign("config", $form);
                                $v->assign("errors", '');
                                $v->assign("fieldValues", null);

                                $alert = new Alert("Mot de passe renouvelé avec succès", 'success');

                                $targetedUser[0]->setPwd($params['POST']['password']);
                                $targetedUser[0]->setToken();
                                $targetedUser[0]->save();
                            }
                        }
                        //si aucun champ n'est envoyé via post (accès à la page pour la 1ère fois)
                        else
                        {
                            $form = Auth::renewPasswordForm();
                            $v = new View("auth-renewPassword", "auth");
                            $v->assign("config", $form);
                            $v->assign("errors", '');
                            $v->assign("fieldValues", null);
                        }
                    }
                    //redirection sur la page de login si token pas correspondant
                    else
                    {
                        //bouton pour renvoyer un mail de confirmation
                        header('Location: '.DIRNAME.'index/login');
                    }
                }
                //retour sur la page de login si les paramètres ne sont pas tous renseignés
                else
                {
                    header('Location: '.DIRNAME.'index/login');
                }
            }
            //retour sur la page de login si les paramètres ne sont pas tous renseignés
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }
    }