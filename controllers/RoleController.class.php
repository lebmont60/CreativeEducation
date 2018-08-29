<?php
    class RoleController
    {
        public function indexAction($params)
        {
            $user = new User();

            //vérification user connecté
            if($user->isConnected())
            {
                //vérification user admin
                if($user->isAdmin())
                {
                    $role = new Role;
                    //tableau des roles
                    $table = $role->listRoleTable();
                    $v = new View("back-roles", "back");
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
                        $role = new Role();
                        $form = $role->addRoleForm();
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
                        //sinon on renvoie sur la même page avec message de succès + on enregistre le role
                        else
                        {
                            //permet de savoir si le role existe déjà
                            $queryConditions = [
                                "select"=>[
                                    "role.*"
                                ],
                                "join"=>[
                                    "inner_join"=>[],
                                    "left_join"=>[],
                                    "right_join"=>[]
                                ],
                                "where"=>[
                                    "clause"=>"LOWER(`role`.`name`) = '".mb_strtolower(addslashes($params['POST']['name']))."'",
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

                            $targetedRole = $role->getAll($queryConditions);

                            /*var_dump($queryConditions);
                            var_dump($targetedRole);*/

                            //si le role existe déjà : erreur
                            if(count($targetedRole) != 0)
                            {
                                $form = $role->addRoleForm();
                                $v = new View("back-add", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $params['POST']);
                                $alert = new Alert("Ce rôle existe déjà", 'error');
                            }
                            //sinon on enregistre le role
                            else
                            {
                                $role->setName($params['POST']['name']);
                                $role->setStatus('1');
                                $role->save();

                                $form = $role->addRoleForm();
                                $v = new View("back-add", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $params['POST']);
                                $alert = new Alert("Le rôle a été ajoutée avec succès", 'success');
                            }
                        }
                    }
                    //sinon, premier chargement de la page
                    else
                    {
                        $role = new Role();
                        $form = $role->addRoleForm();
                        
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
                if($user->isAdmin())
                {
                    //si tous les champs sont remplis
                    if(!empty($params['POST']))
                    {
                        $role = new Role();
                        $form = $role->updateRoleForm();
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
                        //sinon on renvoie sur la même page avec message de succès + on met à jour le rôle
                        else
                        {
                            //permet de savoir si le role existe déjà
                            $queryConditions = [
                                "select"=>[
                                    "role.*"
                                ],
                                "join"=>[
                                    "inner_join"=>[],
                                    "left_join"=>[],
                                    "right_join"=>[]
                                ],
                                "where"=>[
                                    "clause"=>"LOWER(`role`.`name`) = '".mb_strtolower(addslashes($params['POST']['name']))."'",
                                    "and"=>[],
                                    "or"=>[]
                                ],
                                "and"=>[
                                    [
                                        "clause"=>"`role`.`id` != '".$params['URL'][0]."'",
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

                            $targetedRole = $role->getAll($queryConditions);

                            //si la role existe déjà : erreur
                            if(count($targetedRole) != 0)
                            {
                                $queryConditions = [
                                    'select'=>[
                                        'role.*'
                                    ],
                                    'join'=>[
                                        'inner_join'=>[],
                                        'left_join'=>[],
                                        'right_join'=>[]
                                    ],
                                    'where'=>[
                                        'clause'=>'`role`.`id` = '.$params['URL'][0],
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

                                $targetedRole = $role->getAll($queryConditions)[0];

                                //données à transmettre dans la form afin de pré remplir les champs
                                $fieldValues = [
                                    'name' => $targetedRole->getName(),
                                    'status' => $targetedRole->getStatus()
                                ];

                                $form = $role->updateRoleForm();
                                $v = new View("back-update", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $fieldValues);
                                $alert = new Alert("Ce rôle existe déjà", 'error');
                            }
                            else
                            {
                                //id du rôle à modifier
                                $id = $params['URL'][0];

                                //récupération rôle
                                $queryConditions = [
                                    'select'=>[
                                        'role.*'
                                    ],
                                    'join'=>[
                                        'inner_join'=>[],
                                        'left_join'=>[],
                                        'right_join'=>[]
                                    ],
                                    'where'=>[
                                        'clause'=>'`role`.`id` = '.$id,
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

                                $role = new Role();
                                $targetedRole = $role->getAll($queryConditions)[0];

                                //attribution nouvelles données
                                $targetedRole->setName($params['POST']['name']);

                                //mise à jour
                                $targetedRole->save();

                                //affichage message succès
                                $v = new View("back-update", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", '');
                                $v->assign("fieldValues", $params['POST']);

                                $alert = new Alert("Modification effectuée", 'success');
                            }
                        }
                    }
                    else
                    {
                        //id du rôle à modifier
                        $id = $params['URL'][0];

                        $queryConditions = [
                            'select'=>[
                                'role.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'`role`.`id` = '.$id,
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

                        $role = new Role();
                        $targetedRole = $role->getAll($queryConditions)[0];

                        //données à transmettre dans la form afin de pré remplir les champs
                        $fieldValues = [
                            'name' => $targetedRole->getName()
                        ];

                        $form = $role->updateRoleForm();
                        
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
                if($user->isAdmin())
                {
                    //id du user à supprimer
                    $id = $params['URL'][0];

                    //si l'id est renseigné et qu'il s'agit d'un nombre
                    if(trim($id) != '' && is_numeric($id))
                    {
                        $queryConditions = [
                            'select'=>[
                                'role.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'role.id = '.$id,
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

                        $role = new Role;

                        $targetedRole = $role->getAll($queryConditions);
                        $targetedRole[0]->setStatus('0');
                        $targetedRole[0]->save();

                        header('Location: '.DIRNAME.'role/index');
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
                if($user->isAdmin())
                {
                    //id du user à supprimer
                    $id = $params['URL'][0];

                    //si l'id est renseigné et qu'il s'agit d'un nombre
                    if(trim($id) != '' && is_numeric($id))
                    {
                        $queryConditions = [
                            'select'=>[
                                'role.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'role.id = '.$id,
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

                        $role = new Role;

                        $targetedRole = $role->getAll($queryConditions);
                        $targetedRole[0]->setStatus('1');
                        $targetedRole[0]->save();

                        header('Location: '.DIRNAME.'role/index');
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