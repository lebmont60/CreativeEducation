<?php
    class UserController
    {
        public function indexAction($params)
        {
            $user = new User();

            //vérification user connecté
            if($user->isConnected())
            {
                //vérification user admin
                if($user->isAdmin() || $user->isProfessor())
                {
                    //tableau des users
                    $table = $user->listUserTable();
                    $v = new View("back-users", "back");
                    $v->assign('config', $table);
                }
                //sinon on le renvoie la home
                else
                {
                    header('Location: '.DIRNAME.'index/home');
                }
            }
            //sinon on renvoie vers la page de login
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }

        public function addAction($params)
        {
            $user = new User();

            //vérification user connecté
            if($user->isConnected())
            {
                //vérification user admin
                if($user->isAdmin() || $user->isProfessor())
                {
                    //si tous les champs sont remplis
                    if(!empty($params['POST']))
                    {
                        $user = new User();
                        $form = $user->addUserForm();
                        $errors = Validator::validate($form, $params['POST']);

                        //s'il y a des erreurs avec les données saisies dans le formulaire on les affiche
                        if(!empty($errors))
                        {
                            $v = new View("back-add", "back");
                            $v->assign("config", $form);
                            $v->assign("errors", $errors);
                            $v->assign("fieldValues", $_POST);

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
                                $form = $user->addUserForm();
                                $v = new View("back-add", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", "Adresse mail déjà utilisée");
                                $v->assign("fieldValues", $params['POST']);
                                $alert = new Alert("Adresse mail déjà utilisée", 'error');
                            }
                            //sinon succès
                            else
                            {
                                $form = $user->addUserForm();
                                $v = new View("back-add", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", "Inscription terminée, veuillez consulter vos mails");
                                $v->assign("fieldValues", $_POST);
                                $alert = new Alert("Utilisateur ajouté", 'success');

                                $user = new User();
                                $user->setFirstname($params['POST']['firstname']);
                                $user->setLastname($params['POST']['lastname']);
                                //mot de passe par défaut qui pourra être changé plus tard
                                $user->setPwd('CreaEdu2018');
                                $user->setemail($params['POST']['email']);
                                $user->setStatus('1');
                                $user->setToken();
                                $user->setId_role($params['POST']['role']);
                                $user->setId_user_group($params['POST']['group']);
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
                                $url = DIRNAME.'index/login';

                                //récupération du fichier (template avec affichage du mot de passe, uniquement lors de la création d'un user via back end)
                                $content = file_get_contents('views/mail-wth-pwd.php');

                                //remplacement de la chaine pour l'url de redirection
                                $content = str_replace('{%%url%%}', $url, $content);

                                //remplacement de la chaine pour le mot de passe
                                $content = str_replace('{%%password%%}', 'CreaEdu2018', $content);

                                //envoi de mail
                                $user->sendMail('Validation de votre compte CreativeEducation', $content);
                            }
                        }
                    }
                    //sinon, premier chargement de la page
                    else
                    {
                        $user = new User();
                        $form = $user->addUserForm();
                        
                        $v = new View("back-add", "back");
                        $v->assign("config", $form);
                        $v->assign("errors", '');
                        $v->assign("fieldValues", null);
                    }
                }
                //sinon on le renvoie la home
                else
                {
                    header('Location: '.DIRNAME.'index/home');
                }
            }
            //sinon on renvoie vers la page de login
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }

        public function updateAction($params)
        {
            $user = new User();

            //vérification user connecté
            if($user->isConnected())
            {
                //vérification user admin
                if($user->isAdmin() || $user->isProfessor())
                {
                    //si tous les champs sont remplis
                    if(!empty($params['POST']))
                    {
                        $form = $user->updateUserForm();
                        $errors = Validator::validate($form, $params['POST']);

                        //s'il y a des erreurs avec les données saisies dans le formulaire on les affiche
                        if(!empty($errors))
                        {
                            $v = new View("back-update", "back");
                            $v->assign("config", $form);
                            $v->assign("errors", $errors);
                            $v->assign("fieldValues", $params['POST']);

                            //alerts
                            foreach($errors as $error)
                            {
                                $alert = new Alert($error, 'error');
                            }
                        }
                        //sinon on renvoie sur la même page avec message de succès + on met à jour l'utilisateur
                        else
                        {
                            //id du user à modifier
                            $id = $params['URL'][0];

                            //récupération user
                            $queryConditions = [
                                'select'=>[
                                    'user.*'
                                ],
                                'join'=>[
                                    'inner_join'=>[],
                                    'left_join'=>[],
                                    'right_join'=>[]
                                ],
                                'where'=>[
                                    'clause'=>'`user`.`id` = '.$id,
                                    'and'=>[],
                                    'or'=>[]
                                ],
                                'and'=>[
                                    [
                                        'clause'=>'',
                                        'and'=>[],
                                        'or'=>[]
                                    ]
                                ],
                                'or'=>[
                                    [
                                        'clause'=>'',
                                        'and'=>[],
                                        'or'=>[]
                                    ]
                                ],
                                'group_by'=>[],
                                'having'=>[
                                    'clause'=>'',
                                    'and'=>[],
                                    'or'=>[]
                                ],
                                'order_by'=>[
                                    'asc'=>[],
                                    'desc'=>[]
                                ],
                                'limit'=>[
                                    'offset'=>'',
                                    'range'=>''
                                ]
                            ];

                            $user = new User();
                            $targetedUser = $user->getAll($queryConditions)[0];

                            //attribution nouvelles données
                            $targetedUser->setFirstname($params['POST']['firstname']);
                            $targetedUser->setLastname($params['POST']['lastname']);
                            $targetedUser->setEmail($params['POST']['email']);
                            $targetedUser->setId_role($params['POST']['role']);
                            $targetedUser->setId_user_group($params['POST']['group']);

                            //mise à jour
                            $targetedUser->save();

                            //affichage message succès
                            $v = new View("back-update", "back");
                            $v->assign("config", $form);
                            $v->assign("errors", '');
                            $v->assign("fieldValues", $params['POST']);

                            $alert = new Alert("Modification effectuée", 'success');
                        }
                    }
                    else
                    {
                        //id du user à modifier
                        $id = $params['URL'][0];

                        $queryConditions = [
                            'select'=>[
                                'user.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'`user`.`id` = '.$id,
                                'and'=>[],
                                'or'=>[]
                            ],
                            'and'=>[
                                [
                                    'clause'=>'',
                                    'and'=>[],
                                    'or'=>[]
                                ]
                            ],
                            'or'=>[
                                [
                                    'clause'=>'',
                                    'and'=>[],
                                    'or'=>[]
                                ]
                            ],
                            'group_by'=>[],
                            'having'=>[
                                'clause'=>'',
                                'and'=>[],
                                'or'=>[]
                            ],
                            'order_by'=>[
                                'asc'=>[],
                                'desc'=>[]
                            ],
                            'limit'=>[
                                'offset'=>'',
                                'range'=>''
                            ]
                        ];

                        $user = new User();
                        $targetedUser = $user->getAll($queryConditions)[0];

                        //données à transmettre dans la form afin de pré remplir les champs
                        $fieldValues = [
                            'firstname' => Helpers::cleanFirstname($targetedUser->getFirstname()),
                            'lastname' => Helpers::cleanLastname($targetedUser->getLastname()),
                            'email' => $targetedUser->getEmail(),
                            'role' => $targetedUser->getId_role(),
                            'group' => $targetedUser->getId_user_group()
                        ];

                        $form = $user->updateUserForm();
                        
                        $v = new View("back-update", "back");
                        $v->assign("config", $form);
                        $v->assign("errors", '');
                        $v->assign("fieldValues", $fieldValues);
                    }
                }
                //sinon on le renvoie la home
                else
                {
                    header('Location: '.DIRNAME.'index/home');
                }
            }
            //sinon on renvoie vers la page de login
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }

        public function deleteAction($params)
        {
            $user = new User();

            //vérification user connecté
            if($user->isConnected())
            {
                //vérification user admin
                if($user->isAdmin() || $user->isProfessor())
                {
                    //id du user à supprimer
                    $id = $params['URL'][0];

                    //si l'id est renseigné et qu'il s'agit d'un nombre
                    if(trim($id) != '' && is_numeric($id))
                    {
                        $queryConditions = [
                            'select'=>[
                                'user.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'`user`.`id` = '.$id,
                                'and'=>[],
                                'or'=>[]
                            ],
                            'and'=>[
                                [
                                    'clause'=>'',
                                    'and'=>[],
                                    'or'=>[]
                                ]
                            ],
                            'or'=>[
                                [
                                    'clause'=>'',
                                    'and'=>[],
                                    'or'=>[]
                                ]
                            ],
                            'group_by'=>[],
                            'having'=>[
                                'clause'=>'',
                                'and'=>[],
                                'or'=>[]
                            ],
                            'order_by'=>[
                                'asc'=>[],
                                'desc'=>[]
                            ],
                            'limit'=>[
                                'offset'=>'',
                                'range'=>''
                            ]
                        ];

                        $targetedUser = $user->getAll($queryConditions);
                        $targetedUser[0]->setStatus('0');
                        $targetedUser[0]->save();

                        header('Location: '.DIRNAME.'user/index');
                    }
                    //sinon 404
                    else
                    {
                        header('Location: '.DIRNAME.'error/404');
                    }
                }
                //sinon on le renvoie la home
                else
                {
                    header('Location: '.DIRNAME.'index/home');
                }
            }
            //sinon on renvoie vers la page de login
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }

        public function activateAction($params)
        {
            $user = new User();

            //vérification user connecté
            if($user->isConnected())
            {
                //vérification user admin
                if($user->isAdmin() || $user->isProfessor())
                {
                    //id du user à supprimer
                    $id = $params['URL'][0];

                    //si l'id est renseigné et qu'il s'agit d'un nombre
                    if(trim($id) != '' && is_numeric($id))
                    {
                        $queryConditions = [
                            'select'=>[
                                'user.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'`user`.`id` = '.$id,
                                'and'=>[],
                                'or'=>[]
                            ],
                            'and'=>[
                                [
                                    'clause'=>'',
                                    'and'=>[],
                                    'or'=>[]
                                ]
                            ],
                            'or'=>[
                                [
                                    'clause'=>'',
                                    'and'=>[],
                                    'or'=>[]
                                ]
                            ],
                            'group_by'=>[],
                            'having'=>[
                                'clause'=>'',
                                'and'=>[],
                                'or'=>[]
                            ],
                            'order_by'=>[
                                'asc'=>[],
                                'desc'=>[]
                            ],
                            'limit'=>[
                                'offset'=>'',
                                'range'=>''
                            ]
                        ];

                        $targetedUser = $user->getAll($queryConditions);
                        $targetedUser[0]->setStatus('1');
                        $targetedUser[0]->save();

                        header('Location: '.DIRNAME.'user/index');
                    }
                    //sinon 404
                    else
                    {
                        header('Location: '.DIRNAME.'error/404');
                    }
                }
                //sinon on le renvoie la home
                else
                {
                    header('Location: '.DIRNAME.'index/home');
                }
            }
            //sinon on renvoie vers la page de login
            else
            {
                header('Location: '.DIRNAME.'index/login');
            }
        }
    }