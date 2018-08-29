<?php
    class Course extends BaseSQL
    {
        protected $id = null;
        protected $title;
        protected $description;
        protected $filePath;
        protected $fileName;
        protected $status;
        //protected $insertedDate;
        //protected $updatedDate;
        protected $id_user;
        protected $id_course_category;

        public function __construct()
        {
            parent::__construct();
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setTitle($title)
        {
            $this->title = $title;
        }

        public function setDescription($description)
        {
            $this->description = $description;
        }

        public function setFilePath($filePath)
        {
            $this->filePath = $filePath;
        }

        public function setFileName($fileName)
        {
            $this->fileName = $fileName;
        }

        public function setStatus($status)
        {
            $this->status = $status;
        }

        public function setId_user($id_user)
        {
            $this->id_user = $id_user;
        }

        public function setId_course_category($id_course_category)
        {
            $this->id_course_category = $id_course_category;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function getDescription()
        {
            return htmlspecialchars($this->description);
        }

        public function getFilePath()
        {
            return $this->filePath;
        }

        public function getFileName()
        {
            return htmlspecialchars($this->fileName);
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

        public function getId_course_category()
        {
            return $this->id_course_category;
        }

        public function addCourseForm()
        {
            //récupération de toutes les catégories pour alimenter la liste déroulante
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
                    "clause"=>"`course_category`.`status` = '1'",
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
                        "`course_category`.`id`"
                    ],
                    "desc"=>[]
                ],
                "limit"=>[
                    "offset"=>"",
                    "range"=>""
                ]
            ];

            $course_category = new Course_category();
            $categories = $course_category->getAll($queryConditions);
            $optionsCategories = [];

            foreach($categories as $category)
            {
                $optionsCategories[$category->getId()] = $category->getName();
            }

            //récupération des groupes que l'on peut attribuer lors de la création d'un nouveau cours
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
                    "clause"=>"`user_group`.`status` = '1'",
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
                        "`user_group`.`id`"
                    ],
                    "desc"=>[]
                ],
                "limit"=>[
                    "offset"=>"",
                    "range"=>""
                ]
            ];

            $user_group = new User_group();
            $groups = $user_group->getAll($queryConditions);
            $optionsGroups = [];

            foreach($groups as $group)
            {
                $optionsGroups[$group->getId()] = $group->getName();
            }

            return [
                "config" => [
                    "method" => "POST",
                    "action" => "course/add",
                    "enctype" => "multipart/form-data"
                ],
                "input" => [
                    "title" => [
                        "type" => "text",
                        "placeholder" => "Titre",
                        "required" => true,
                        "minString" => 5,
                        "maxString" => 250
                    ],
                    "file" => [
                        "type" => "file",
                        "placeholder" => "Fichier (.pdf, .txt, < 5 Mo)",
                        "required" => true,
                        "extensions" => [
                            "txt",
                            "pdf"
                        ],
                        "maxBytes" => 5242880
                    ]
                ],
                "textarea" => [
                    "description" => [
                        "placeholder" => "Description",
                        "required" => true,
                        "minString" => 5,
                        "maxString" => 500,
                        "rows" => 1
                    ]
                ],
                "select" => [
                    "category" => [
                        "placeholder" => "Catégorie",
                        "emptyOption" => false,
                        "options" => $optionsCategories,
                        "required" => true
                    ],
                    "groups" => [
                        "placeholder" => "Groupe(s)",
                        "emptyOption" => false,
                        "options" => $optionsGroups,
                        "required" => true,
                        "multiple" => true
                    ]
                ],
                "button" => [
                    "text" => "AJOUTER"
                ],
                "captcha" => false
            ];
        }

        public function updateCourseForm()
        {
            //récupération de toutes les catégories pour alimenter la liste déroulante
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
                    "clause"=>"`course_category`.`status` = '1'",
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
                        "`course_category`.`id`"
                    ],
                    "desc"=>[]
                ],
                "limit"=>[
                    "offset"=>"",
                    "range"=>""
                ]
            ];

            $course_category = new Course_category();
            $categories = $course_category->getAll($queryConditions);

            foreach($categories as $category)
            {
                $optionsCategories[$category->getId()] = $category->getName();
            }

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
                $optionsStatus[$status->getId()] = $status->getName();
            }

            //récupération des groupes que l'on peut attribuer lors de la modification d'un cours
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
                    "clause"=>"`user_group`.`status` = '1'",
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
                        "`user_group`.`id`"
                    ],
                    "desc"=>[]
                ],
                "limit"=>[
                    "offset"=>"",
                    "range"=>""
                ]
            ];

            $user_group = new User_group();
            $groups = $user_group->getAll($queryConditions);
            $optionsGroups = [];

            foreach($groups as $group)
            {
                $optionsGroups[$group->getId()] = $group->getName();
            }

            return [
                "config" => [
                    "method" => "POST",
                    "action" => ""
                ],
                "input" => [
                    "title" => [
                        "type" => "text",
                        "placeholder" => "Titre",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 250
                    ]
                ],
                "textarea" => [
                    "description" => [
                        "placeholder" => "Description",
                        "required" => true,
                        "minString" => 5,
                        "maxString" => 500,
                        "rows" => 1
                    ]
                ],
                "select" => [
                    "category" => [
                        "placeholder" => "Catégorie",
                        "emptyOption" => false,
                        "options" => $optionsCategories,
                        "required" => true,
                    ],
                    "status" => [
                        "placeholder" => "Statut",
                        "emptyOption" => false,
                        "options" => $optionsStatus,
                        "required" => true
                    ],
                    "groups" => [
                        "placeholder" => "Groupe(s)",
                        "emptyOption" => false,
                        "options" => $optionsGroups,
                        "required" => true,
                        "multiple" => true
                    ]
                ],
                "button" => [
                    "text" => "VALIDER LES MODIFICATIONS"
                ],
                "captcha" => false
            ];
        }

        public function listCourseTable()
        {
            $user = new User();

            //si user est professeur, on récupère uniquement les cours qu'il a créés
            if($user->isProfessor())
            {
                //cours liés au professeur connecté
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
                        "clause"=>"`course`.`id_user` = '".$_SESSION['user']['id']."'",
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

                $course = new Course();
                $courses = $course->getAll($queryConditions);
            }
            //si user est admin, on récupère tous les cours
            elseif($user->isAdmin())
            {
                $course = new Course();
                $courses = $course->getAll();
            }

            //création tableau à fournir au modal
            $arrayCourses = [];

            foreach($courses as $course)
            {
                //récupération de la category
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
                        "clause"=>"`course_category`.`id` = '".$course->getId_course_category()."'",
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

                $course_category = new Course_category();
                $targetedCategory = $course_category->getAll($queryConditions)[0];

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
                        "clause"=>"`status`.`id` = '".$course->getStatus()."'",
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

                //récupération du user qui a créé le cours
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
                        "clause"=>"`user`.`id` = '".$course->getId_user()."'",
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

                $targetedUser = $user->getAll($queryConditions)[0];

                $idCourse = $course->getId();
                $arrayCourses[$idCourse]['title'] = $course->getTitle();
                $arrayCourses[$idCourse]['category'] = $targetedCategory->getName();
                $arrayCourses[$idCourse]['filename'] = $course->getFileName();
                $arrayCourses[$idCourse]['insertedDate'] = Helpers::europeanDateFormat($course->getInsertedDate());
                $arrayCourses[$idCourse]['creator'] = Helpers::cleanFirstname($targetedUser->getFirstname()).' '.Helpers::cleanLastname($targetedUser->getLastname());
                $arrayCourses[$idCourse]['status'] = $targetedStatus->getName();
                $arrayCourses[$idCourse]['actions']['edit']['path'] = 'course/update/'.$idCourse;
                $arrayCourses[$idCourse]['actions']['edit']['icon'] = 'build';
                $arrayCourses[$idCourse]['actions']['edit']['color'] = 'blue';

                //changement du bouton en fonction du statut du user : si activé, on affiche le bouton de désactivation
                if($course->getStatus() == 1)
                {
                    $arrayCourses[$idCourse]['actions']['delete']['path'] = 'course/delete/'.$idCourse;
                    $arrayCourses[$idCourse]['actions']['delete']['icon'] = 'close';
                    $arrayCourses[$idCourse]['actions']['delete']['color'] = 'red';
                }
                //sinon on affiche le bouton d'activation
                elseif($course->getStatus() == 0)
                {
                    $arrayCourses[$idCourse]['actions']['delete']['path'] = 'course/activate/'.$idCourse;
                    $arrayCourses[$idCourse]['actions']['delete']['icon'] = 'check';
                    $arrayCourses[$idCourse]['actions']['delete']['color'] = 'green';
                }
            }

            return [
                "thead" => [
                    "Titre",
                    "Catégorie",
                    "Fichier",
                    "Date d'ajout",
                    "Créateur",
                    "Statut",
                    "Actions"
                ],
                "content" => $arrayCourses
            ];
        }
    }