<?php
    class UsergroupController
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
                    $user_group = new User_group();
                    //tableau des cours
                    $table = $user_group->listUserGroupTable();
                    $v = new View("back-usersGroups", "back");
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
                        $user_group = new User_group();
                        $form = $user_group->addUserGroupForm();
                        $errors = Validator::validate($form, $params['POST']);

                        //s'il y a des erreurs avec les données saisies dans le formulaire on les affiche
                        if(!empty($errors))
                        {
                            $v = new View("back-add", "back");
                            $v->assign("config", $form);
                            $v->assign("errors", $errors);
                            $v->assign("fieldValues", $params['POST']);

                            //alerts
                            foreach($errors as $error)
                            {
                                $alert = new Alert($error, 'error');
                            }
                        }
                        //sinon on renvoie sur la même page avec message de succès + on enregistre le group
                        else
                        {
                            //permet de savoir si le group existe déjà
                            $queryConditions = [
                                "select"=>[
                                    "group.*"
                                ],
                                "join"=>[
                                    "inner_join"=>[],
                                    "left_join"=>[],
                                    "right_join"=>[]
                                ],
                                "where"=>[
                                    "clause"=>"LOWER(`group`.`name`) = '".mb_strtolower($params['POST']['name'])."'",
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

                            $targetedUserGroup = $user_group->getAll($queryConditions);

                            //si le group existe déjà : erreur
                            if(count($targetedUserGroup) == 1)
                            {
                                $form = $user_group->addUserGroupForm();
                                $v = new View("back-add", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $params['POST']);
                                $alert = new Alert("Ce groupe existe déjà", 'error');
                            }
                            //sinon on enregistre le group
                            else
                            {
                                $user_group->setName($params['POST']['name']);
                                $user_group->setStatus('1');
                                $user_group->setId_user($_SESSION['user']['id']);
                                $user_group->save();

                                $form = $user_group->addUserGroupForm();
                                $v = new View("back-add", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $params['POST']);
                                $alert = new Alert("Le groupe a été ajoutée avec succès", 'success');
                            }
                        }
                    }
                    //sinon, premier chargement de la page
                    else
                    {
                        $user_group = new User_group();
                        $form = $user_group->addUserGroupForm();
                        
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
                        $user_group = new User_group();
                        $form = $user_group->updateUserGroupForm();
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
                        //sinon on renvoie sur la même page avec message de succès + on met à jour le group
                        else
                        {
                            //permet de savoir si le group existe déjà
                            $queryConditions = [
                                "select"=>[
                                    "user_group.*"
                                ],
                                "join"=>[
                                    "inner_join"=>[],
                                    "left_join"=>[],
                                    "right_join"=>[]
                                ],
                                "where"=>[
                                    "clause"=>"LOWER(`user_group`.`name`) = '".mb_strtolower(addslashes($params['POST']['name']))."'",
                                    "and"=>[],
                                    "or"=>[]
                                ],
                                "and"=>[
                                    [
                                        "clause"=>"`user_group`.`id` != '".$params['URL'][0]."'",
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

                            $targetedUserGroup = $user_group->getAll($queryConditions);

                            //si le group existe déjà : erreur
                            if(count($targetedUserGroup) == 1)
                            {
                                $queryConditions = [
                                    'select'=>[
                                        'user_group.*'
                                    ],
                                    'join'=>[
                                        'inner_join'=>[],
                                        'left_join'=>[],
                                        'right_join'=>[]
                                    ],
                                    'where'=>[
                                        'clause'=>'`user_group`.`id` = '.$params['URL'][0],
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

                                $targetedUserGroup = $user_group->getAll($queryConditions)[0];

                                //données à transmettre dans la form afin de pré remplir les champs
                                $fieldValues = [
                                    'name' => $targetedUserGroup->getName(),
                                    'status' => $targetedUserGroup->getStatus()
                                ];

                                $form = $user_group->updateUserGroupForm();
                                $v = new View("back-update", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $fieldValues);
                                $alert = new Alert("Ce groupe existe déjà", 'error');
                            }
                            //sinon on enregistre le group
                            else
                            {
                                //id du cours à modifier
                                $id = $params['URL'][0];

                                //récupération cours
                                $queryConditions = [
                                    'select'=>[
                                        'user_group.*'
                                    ],
                                    'join'=>[
                                        'inner_join'=>[],
                                        'left_join'=>[],
                                        'right_join'=>[]
                                    ],
                                    'where'=>[
                                        'clause'=>'`user_group`.`id` = '.$id,
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

                                $user_group = new User_group();
                                $targetedUserGroup = $user_group->getAll($queryConditions)[0];

                                //attribution nouvelles données
                                $targetedUserGroup->setName($params['POST']['name']);
                                $targetedUserGroup->setStatus($params['POST']['status']);

                                //mise à jour
                                $targetedUserGroup->save();

                                //affichage message succès
                                $v = new View("back-update", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", '');
                                $params['POST']['name'] = htmlspecialchars($params['POST']['name']);
                                $v->assign("fieldValues", $params['POST']);

                                $alert = new Alert("Modification effectuée", 'success');
                            }
                        }
                    }
                    else
                    {
                        //id du cours à modifier
                        $id = $params['URL'][0];

                        $queryConditions = [
                            'select'=>[
                                'user_group.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'`user_group`.`id` = '.$id,
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

                        $user_group = new User_group();
                        $targetedUserGroup = $user_group->getAll($queryConditions)[0];

                        //var_dump($targetedUserGroup); die();

                        //données à transmettre dans la form afin de pré remplir les champs
                        $fieldValues = [
                            'name' => $targetedUserGroup->getName(),
                            'status' => $targetedUserGroup->getStatus()
                        ];

                        $form = $user_group->updateUserGroupForm();
                        
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
                    //id du group à supprimer
                    $id = $params['URL'][0];

                    //si l'id est renseigné et qu'il s'agit d'un nombre
                    if(trim($id) != '' && is_numeric($id))
                    {
                        $queryConditions = [
                            'select'=>[
                                'User_group.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'user_group.id = '.$id,
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

                        $user_group = new User_group();

                        $targetedUserGroup = $user_group->getAll($queryConditions);
                        $targetedUserGroup[0]->setStatus('0');
                        $targetedUserGroup[0]->save();

                        header('Location: '.DIRNAME.'usergroup/index');
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
                    //id du group à supprimer
                    $id = $params['URL'][0];

                    //si l'id est renseigné et qu'il s'agit d'un nombre
                    if(trim($id) != '' && is_numeric($id))
                    {
                        $queryConditions = [
                            'select'=>[
                                'user_group.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'`user_group`.`id` = '.$id,
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

                        $user_group = new User_group();

                        $targetedUserGroup = $user_group->getAll($queryConditions);
                        $targetedUserGroup[0]->setStatus('1');
                        $targetedUserGroup[0]->save();

                        header('Location: '.DIRNAME.'usergroup/index');
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