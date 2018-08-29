<?php
    class Course_category extends BaseSQL
    {
        protected $id = null;
        protected $name;
        protected $status;
        //protected $insertedDate;
        //protected $updatedDate;
        protected $id_user;

        public function __construct()
        {
            parent::__construct();
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function setStatus($status)
        {
            $this->status = $status;
        }

        public function setId_user($id_user)
        {
            $this->id_user = $id_user;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getName()
        {
            return htmlspecialchars($this->name);
        }

        public function getStatus()
        {
            return htmlspecialchars($this->status);
        }

        public function getInsertedDate()
        {
            return $this->insertedDate;
        }

        public function getUpdatedDate()
        {
            return $this->updatedDate;
        }

        public function getId_user()
        {
            return $this->id_user;
        }

        public function addCourseCategoryForm()
        {
            return [
                "config" => [
                    "method" => "POST",
                    "action" => "coursecategory/add"
                ],
                "input" => [
                    "name" => [
                        "type" => "text",
                        "placeholder" => "Nom",
                        "required" => true,
                        "minString" => 5,
                        "maxString" => 250
                    ]
                ],
                "button" => [
                    "text" => "AJOUTER"
                ],
                "captcha" => false
            ];
        }

        public function updateCourseCategoryForm()
        {
            //récupération de tous les status pour alimenter la liste déroulante
            $queryConditions = [
                "select"=>[
                    "status.*"
                ],
                "join"=>[
                    "inner_join"=>[],
                    "left_join"=>[],
                    "right_join"=>[]
                ],
                "where"=>[
                    "clause"=>"`status`.`id` != '-1'",
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
                    "asc"=>[
                        "`status`.`name`"
                    ],
                    "desc"=>[]
                ],
                "limit"=>[
                    "offset"=>"",
                    "range"=>""
                ]
            ];

            $status = new Status();
            $statuses = $status->getAll($queryConditions);

            foreach($statuses as $status)
            {
                $options[$status->getId()] = $status->getName();
            }

            return [
                "config" => [
                    "method" => "POST",
                    "action" => ""
                ],
                "input" => [
                    "name" => [
                        "type" => "text",
                        "placeholder" => "Nom",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 250
                    ]
                ],
                "select" => [
                    "status" => [
                        "placeholder" => "Statut",
                        "emptyOption" => false,
                        "options" => $options,
                        "required" => true
                    ]
                ],
                "button" => [
                    "text" => "VALIDER LES MODIFICATIONS"
                ],
                "captcha" => false
            ];
        }

        public function listCourseCategoryTable()
        {
            //récupération de toutes les catégories
            $course_category = new Course_category();
            $categories = $course_category->getAll();

            //création d'un tableau à fournir au modal
            $arrayCategories = [];

            foreach($categories as $category)
            {
                //récupération du status
                $queryConditions = [
                    "select"=>[
                        "status.*"
                    ],
                    "join"=>[
                        "inner_join"=>[],
                        "left_join"=>[],
                        "right_join"=>[]
                    ],
                    "where"=>[
                        "clause"=>"`status`.`id` = '".$category->getStatus()."'",
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

                $status = new Status();
                $targetedStatus = $status->getAll($queryConditions)[0];

                //récupération du user qui a créé la category
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
                        "clause"=>"`user`.`id` = '".$category->getId_user()."'",
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

                //récupération du nombre de cours liés à la category
                $queryConditions = [
                    "select"=>[
                        "course.*"
                    ],
                    "join"=>[
                        "inner_join"=>[],
                        "left_join"=>[],
                        "right_join"=>[]
                    ],
                    "where"=>[
                        "clause"=>"`course`.`id_course_category` = '".$category->getId()."'",
                        "and"=>[],
                        "or"=>[]
                    ],
                    "and"=>[
                        [
                            "clause"=>"`course`.`status` = '1'",
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

                $course = new Course();
                $nbLinkedCourses = count($course->getAll($queryConditions));

                $idCategory = $category->getId();
                $arrayCategories[$idCategory]['name'] = $category->getName();
                $arrayCategories[$idCategory]['creator'] = Helpers::cleanFirstname($targetedUser->getFirstname()).' '.Helpers::cleanLastname($targetedUser->getLastname());
                $arrayCategories[$idCategory]['nbLinkedCourses'] = $nbLinkedCourses;
                $arrayCategories[$idCategory]['insertedDate'] = Helpers::europeanDateFormat($category->getInsertedDate());
                $arrayCategories[$idCategory]['status'] = $targetedStatus->getName();
                $arrayCategories[$idCategory]['actions']['edit']['path'] = 'coursecategory/update/'.$idCategory;
                $arrayCategories[$idCategory]['actions']['edit']['icon'] = 'build';
                $arrayCategories[$idCategory]['actions']['edit']['color'] = 'blue';

                //changement du bouton en fonction du statut de la category : si activé, on affiche le bouton de désactivation
                if($category->getStatus() == 1)
                {
                    $arrayCategories[$idCategory]['actions']['delete']['path'] = 'coursecategory/delete/'.$idCategory;
                    $arrayCategories[$idCategory]['actions']['delete']['icon'] = 'close';
                    $arrayCategories[$idCategory]['actions']['delete']['color'] = 'red';
                }
                //sinon on affiche le bouton d'activation
                elseif($category->getStatus() == 0)
                {
                    $arrayCategories[$idCategory]['actions']['delete']['path'] = 'coursecategory/activate/'.$idCategory;
                    $arrayCategories[$idCategory]['actions']['delete']['icon'] = 'check';
                    $arrayCategories[$idCategory]['actions']['delete']['color'] = 'green';
                }
            }

            return [
                "thead" => [
                    "Nom",
                    "Créateur",
                    "Cours liés",
                    "Date d'ajout",
                    "Statut",
                    "Actions"
                ],
                "content" => $arrayCategories
            ];
        }
    }