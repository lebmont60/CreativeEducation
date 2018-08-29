<?php
    class CoursecategoryController
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
                    $course_category = new Course_category();
                    //tableau des cours
                    $table = $course_category->listCourseCategoryTable();
                    $v = new View("back-coursesCategories", "back");
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
                        $course_category = new Course_category();
                        $form = $course_category->addCourseCategoryForm();
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
                        //sinon on renvoie sur la même page avec message de succès + on enregistre la category
                        else
                        {
                            //permet de savoir si la catégorie existe déjà
                            $queryConditions = [
                                "select"=>[
                                    "course_category.*"
                                ],
                                "join"=>[
                                    "inner_join"=>[],
                                    "left_join"=>[],
                                    "right_join"=>[]
                                ],
                                "where"=>[
                                    "clause"=>"LOWER(`course_category`.`name`) = '".mb_strtolower(addslashes($params['POST']['name']))."'",
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

                            $targetedCourseCategory = $course_category->getAll($queryConditions);

                            //si la category existe déjà : erreur
                            if(count($targetedCourseCategory) == 1)
                            {
                                $form = $course_category->addCourseCategoryForm();
                                $v = new View("back-add", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $params['POST']);
                                $alert = new Alert("Cette catégorie existe déjà", 'error');
                            }
                            //sinon on enregistre la category
                            else
                            {
                                $course_category->setName($params['POST']['name']);
                                $course_category->setStatus('1');
                                $course_category->setId_user($_SESSION['user']['id']);
                                $course_category->save();

                                $form = $course_category->addCourseCategoryForm();
                                $v = new View("back-add", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $params['POST']);
                                $alert = new Alert("La catégorie a été ajoutée avec succès", 'success');
                            }
                        }
                    }
                    //sinon, premier chargement de la page
                    else
                    {
                        $course_category = new Course_category();
                        $form = $course_category->addCourseCategoryForm();
                        
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
                        $course_category = new Course_category();
                        $form = $course_category->updateCourseCategoryForm();
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
                        //sinon on renvoie sur la même page avec message de succès + on met à jour la category
                        else
                        {
                            //permet de savoir si la catégorie existe déjà
                            $queryConditions = [
                                "select"=>[
                                    "course_category.*"
                                ],
                                "join"=>[
                                    "inner_join"=>[],
                                    "left_join"=>[],
                                    "right_join"=>[]
                                ],
                                "where"=>[
                                    "clause"=>"LOWER(`course_category`.`name`) = '".mb_strtolower(addslashes($params['POST']['name']))."'",
                                    "and"=>[],
                                    "or"=>[]
                                ],
                                "and"=>[
                                    [
                                        "clause"=>"`course_category`.`id` != '".$params['URL'][0]."'",
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

                            $targetedCourseCategory = $course_category->getAll($queryConditions);

                            //si la category existe déjà : erreur
                            if(count($targetedCourseCategory) == 1)
                            {
                                $queryConditions = [
                                    'select'=>[
                                        'course_category.*'
                                    ],
                                    'join'=>[
                                        'inner_join'=>[],
                                        'left_join'=>[],
                                        'right_join'=>[]
                                    ],
                                    'where'=>[
                                        'clause'=>'`course_category`.`id` = '.$params['URL'][0],
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

                                $targetedCourseCategory = $course_category->getAll($queryConditions)[0];

                                //données à transmettre dans la form afin de pré remplir les champs
                                $fieldValues = [
                                    'name' => $targetedCourseCategory->getName(),
                                    'status' => $targetedCourseCategory->getStatus()
                                ];

                                $form = $course_category->updateCourseCategoryForm();
                                $v = new View("back-update", "back");
                                $v->assign("config", $form);
                                $v->assign("errors", $errors);
                                $v->assign("fieldValues", $fieldValues);
                                $alert = new Alert("Cette catégorie existe déjà", 'error');
                            }
                            //sinon on enregistre la category
                            else
                            {
                                //id du cours à modifier
                                $id = $params['URL'][0];

                                //récupération cours
                                $queryConditions = [
                                    'select'=>[
                                        'course_category.*'
                                    ],
                                    'join'=>[
                                        'inner_join'=>[],
                                        'left_join'=>[],
                                        'right_join'=>[]
                                    ],
                                    'where'=>[
                                        'clause'=>'`course_category`.`id` = '.$id,
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

                                $course_category = new Course_category();
                                $targetedCourseCategory = $course_category->getAll($queryConditions)[0];

                                //attribution nouvelles données
                                $targetedCourseCategory->setName($params['POST']['name']);
                                $targetedCourseCategory->setStatus($params['POST']['status']);

                                //mise à jour
                                $targetedCourseCategory->save();

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
                        //id du cours à modifier
                        $id = $params['URL'][0];

                        $queryConditions = [
                            'select'=>[
                                'course_category.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'`course_category`.`id` = '.$id,
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

                        $course_category = new Course_category();
                        $targetedCourseCategory = $course_category->getAll($queryConditions)[0];

                        //données à transmettre dans la form afin de pré remplir les champs
                        $fieldValues = [
                            'name' => $targetedCourseCategory->getName(),
                            'status' => $targetedCourseCategory->getStatus()
                        ];

                        $form = $course_category->updateCourseCategoryForm();
                        
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
                    //id de la category à supprimer
                    $id = $params['URL'][0];

                    //si l'id est renseigné et qu'il s'agit d'un nombre
                    if(trim($id) != '' && is_numeric($id))
                    {
                        $queryConditions = [
                            'select'=>[
                                'course_category.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'course_category.id = '.$id,
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

                        $course_category = new Course_category();

                        $targetedCourseCategory = $course_category->getAll($queryConditions);
                        $targetedCourseCategory[0]->setStatus('0');
                        $targetedCourseCategory[0]->save();

                        header('Location: '.DIRNAME.'coursecategory/index');
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
                    //id de la category à supprimer
                    $id = $params['URL'][0];

                    //si l'id est renseigné et qu'il s'agit d'un nombre
                    if(trim($id) != '' && is_numeric($id))
                    {
                        $queryConditions = [
                            'select'=>[
                                'course_category.*'
                            ],
                            'join'=>[
                                'inner_join'=>[],
                                'left_join'=>[],
                                'right_join'=>[]
                            ],
                            'where'=>[
                                'clause'=>'`course_category`.`id` = '.$id,
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

                        $course_category = new Course_category();

                        $targetedCourseCategory = $course_category->getAll($queryConditions);
                        $targetedCourseCategory[0]->setStatus('1');
                        $targetedCourseCategory[0]->save();

                        header('Location: '.DIRNAME.'coursecategory/index');
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