<?php
    class User_group extends BaseSQL
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

        public function addUserGroupForm()
        {
            return [
                "config" => [
                    "method" => "POST",
                    "action" => "usergroup/add"
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

        public function updateUserGroupForm()
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

        public function listUserGroupTable()
        {
            //récupération de tous les groupes
            $user_group = new User_group();
            $groups = $user_group->getAll();

            //création d'un tableau à fournir au modal
            $arrayGroups = [];

            foreach($groups as $group)
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
                        "clause"=>"`status`.`id` = '".$group->getStatus()."'",
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

                //récupération du user qui a créé le group
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
                        "clause"=>"`user`.`id` = '".$group->getId_user()."'",
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

                //récupération du nombre d'apprenants liés au group
                /*$queryConditions = [
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
                $nbLinkedCourses = count($course->getAll($queryConditions));*/

                $idGroup = $group->getId();
                $arrayGroups[$idGroup]['name'] = $group->getName();
                $arrayGroups[$idGroup]['creator'] = Helpers::cleanFirstname($targetedUser->getFirstname()).' '.Helpers::cleanLastname($targetedUser->getLastname());
                //$arrayGroups[$idGroup]['nbLinkedStudents'] = $nbLinkedStudents;
                $arrayGroups[$idGroup]['insertedDate'] = Helpers::europeanDateFormat($group->getInsertedDate());
                $arrayGroups[$idGroup]['status'] = $targetedStatus->getName();
                $arrayGroups[$idGroup]['actions']['edit']['path'] = 'usergroup/update/'.$idGroup;
                $arrayGroups[$idGroup]['actions']['edit']['icon'] = 'build';
                $arrayGroups[$idGroup]['actions']['edit']['color'] = 'blue';

                //changement du bouton en fonction du statut du group : si activé, on affiche le bouton de désactivation
                if($group->getStatus() == 1)
                {
                    $arrayGroups[$idGroup]['actions']['delete']['path'] = 'usergroup/delete/'.$idGroup;
                    $arrayGroups[$idGroup]['actions']['delete']['icon'] = 'close';
                    $arrayGroups[$idGroup]['actions']['delete']['color'] = 'red';
                }
                //sinon on affiche le bouton d'activation
                elseif($group->getStatus() == 0)
                {
                    $arrayGroups[$idGroup]['actions']['delete']['path'] = 'usergroup/activate/'.$idGroup;
                    $arrayGroups[$idGroup]['actions']['delete']['icon'] = 'check';
                    $arrayGroups[$idGroup]['actions']['delete']['color'] = 'green';
                }
            }

            return [
                "thead" => [
                    "Nom",
                    "Créateur",
                    //"Cours liés",
                    "Date d'ajout",
                    "Statut",
                    "Actions"
                ],
                "content" => $arrayGroups
            ];
        }
    }