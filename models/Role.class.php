<?php
    class Role extends BaseSQL
    {
        protected $id = null;
        protected $name;
        protected $status;

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

        public function addRoleForm()
        {
            return [
                "config" => [
                    "method" => "POST",
                    "action" => "role/add"
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

        public function updateRoleForm()
        {
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
                        "maxString" => 100
                    ]
                ],
                "button" => [
                    "text" => "VALIDER LES MODIFICATIONS"
                ],
                "captcha" => false
            ];
        }

        public function listRoleTable()
        {
            //récupération de tous les roles
            $role = new Role();
            $roles = $role->getAll();

            //création tableau à fournir au modal
            $arrayRoles = [];

            foreach($roles as $role)
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
                        "clause"=>"`status`.`id` = '".$role->getStatus()."'",
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

                $idRole = $role->getId();
                $arrayRoles[$idRole]['name'] = $role->getName();
                $arrayRoles[$idRole]['status'] = $targetedStatus->getName();
                $arrayRoles[$idRole]['actions']['edit']['path'] = 'role/update/'.$idRole;
                $arrayRoles[$idRole]['actions']['edit']['icon'] = 'build';
                $arrayRoles[$idRole]['actions']['edit']['color'] = 'blue';

                //changement du bouton en fonction du statut du role : si activé, on affiche le bouton de désactivation
                if($role->getStatus() == 1)
                {
                    $arrayRoles[$idRole]['actions']['delete']['path'] = 'role/delete/'.$idRole;
                    $arrayRoles[$idRole]['actions']['delete']['icon'] = 'close';
                    $arrayRoles[$idRole]['actions']['delete']['color'] = 'red';
                }
                //sinon on affiche le bouton d'activation
                elseif($role->getStatus() == 0)
                {
                    $arrayRoles[$idRole]['actions']['delete']['path'] = 'role/activate/'.$idRole;
                    $arrayRoles[$idRole]['actions']['delete']['icon'] = 'check';
                    $arrayRoles[$idRole]['actions']['delete']['color'] = 'green';
                }
            }

            return [
                "thead" => [
                    "Nom",
                    "Statut",
                    "Actions"
                ],
                "content" => $arrayRoles
            ];
        }
    }