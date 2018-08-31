<?php
    class Qcm extends BaseSQL
    {
        protected $id = null;
        protected $title;
        protected $status;
        protected $question;
        protected $insertedDate;
        protected $updatedDate;
        protected $id_user;

        public function __construct()
        {
            parent::__construct();
            $this->foreign_keys = ['Question'];
            $this->question = [];
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setTitle($title)
        {
            $this->title = $title;
        }

        public function setStatus($status)
        {
            $this->status = $status;
        }

        public function setInsertedDate($insertedDate)
        {
            $this->insertedDate = $insertedDate;
        }

        public function setUpdatedDate($updatedDate)
        {
            $this->updatedDate = $updatedDate;
        }

        public function setId_user($id_user)
        {
            $this->id_user = $id_user;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function getStatus()
        {
            return $this->status;
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

        public function getQuestions(){
            return $this->question;
        }

        public function getQuestion($question_content){
            foreach($this->question as $question){
                if($question->getQuestionContent() == $question_content){
                    return $question;
                }
            }
            return null;
        }

        public function addQuestion($question){
            $this->question[]=$question;
        }

        public function removeQuestion($question){
            $cle = array_search($question, $this->question);
            unset($this->question[$cle]);
            $this->question = array_values($this->question);

        }

        public function setQuestion($question){
            $this->question = $question;
            return $this;

        }

        public function addForm()
        {
            return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "submit" => "Ajouter un QCM",
                "id" => "form_add_qcm",
                "class" => 'form',
            ],
            "div" =>[
                [
                    "id" => 'title',
                    "input" => [
                        'qcm_title'=>[
                            "id" => "qcm_title",
                            "label" => 'Titre du QCM',
                            "type" => "text",
                            "placeholder" => "Titre",
                            "required" => true,
                        ],
                    ],
                    "select" =>[],
                    "a"=>[]
                ],
                [
                    "id" => "question_1",
                    "input" => [
                        "Question1[question]" =>[
                            "id" => "Question_1_question",
                            "class" => "question",
                            "label" => 'Question',
                            "type" => "text",
                            "placeholder" => "Question",
                            "required" => true,
                        ],
                        "Question1[reponse1][reponse]" =>[
                            "id" => "Question_1_reponse1_reponse",
                            "type" => 'text',
                            "class"=> 'answer',
                            'label' => 'Réponse n°1',
                            "placeholder" => "Votre réponse",
                        ],
                        "Question1[reponse1][value]" =>[
                            "id" => "Question_1_reponse1_value",
                            "type" => "checkbox",
                            "class"=> 'answer',
                            'label' => 'bonne réponse',
                        ],
                        "Question1[reponse2][reponse]" =>[
                            "id" => "Question_1_reponse2_reponse",
                            "type" => 'text',
                            "class"=> 'answer',
                            'label' => 'Réponse n°2',
                            "placeholder" => "Votre réponse",
                        ],
                        "Question1[reponse2][value]" =>[
                            "id" => "Question_1_reponse2_value",
                            "type" => "checkbox",
                            "class"=> 'answer',
                            'label' => 'bonne réponse',
                        ],
                        "Question1[reponse3][reponse]" =>[
                            "id" => "Question_1_reponse3_reponse",
                            "type" => 'text',
                            "class"=> 'answer',
                            'label' => 'Réponse n°3',
                            "placeholder" => "Votre réponse",
                        ],
                        "Question1[reponse3][value]" =>[
                            "id" => "Question_1_reponse3_value",
                            "type" => "checkbox",
                            "class"=> 'answer',
                            'label' => 'bonne réponse',
                        ],
                        "Question1[reponse4][reponse]" =>[
                            "id" => "Question_1_reponse4_reponse",
                            "type" => 'text',
                            "class"=> 'answer',
                            'label' => 'Réponse n°4',
                            "placeholder" => "Votre réponse",
                        ],
                        "Question1[reponse4][value]" =>[
                            "id" => "Question_1_reponse4_value",
                            "type" => "checkbox",
                            "class"=> 'answer',
                            'label' => 'bonne réponse',
                        ],

                    ],
                    "select"=>[],
                    "a"=>[
                    ]
                ],
                [
                    "input" =>[],
                    "select" =>[],
                    "a" =>[
                        "add_question" =>[
                            "data"=>[
                                "question"=>"<div id='question___index__'><div id='Question___index___question' class='question'>        
                                    <label>Question</label>
                                    <input type='text'name='Question__index__[question]'placeholder='Question' required='required'>
                                    </div><div id='Question___index___reponse1_reponse' class='answer'>
                                    <label>Réponse n°1</label>
                                    <input type='text'name='Question__index__[reponse1][reponse]'placeholder='Votre réponse'>
                                    </div><div id='Question___index___reponse1_value' class='answer' >
                                    <input type='checkbox'name='Question__index__[reponse1][value]'>
                                    <label>bonne réponse</label>
                                    </div><div id='Question___index___reponse2_reponse' class='answer'>
                                    <label>Réponse n°2</label>
                                    <input type='text'name='Question__index__[reponse2][reponse]'placeholder='Votre réponse'>
                                    </div><div id='Question___index___reponse2_value' class='answer'>
                                    <input type='checkbox'name='Question__index__[reponse2][value]'>
                                    <label>bonne réponse</label>
                                    </div><div id='Question___index___reponse3_reponse' class='answer'>
                                    <label>Réponse n°3</label>
                                    <input type='text'name='Question__index__[reponse3][reponse]'placeholder='Votre réponse'>
                                    </div><div id='Question___index___reponse3_value' class='answer' >
                                    <input type='checkbox'name='Question__index__[reponse3][value]'>
                                    <label>bonne réponse</label>
                                    </div><div id='Question___index___reponse4_reponse' class='answer'>
                                    <label>Réponse n°4</label>
                                    <input type='text'name='Question__index__[reponse4][reponse]'placeholder='Votre réponse'>
                                    </div><div id='Question___index___reponse4_value' class='answer'>
                                    <input type='checkbox'name='Question__index__[reponse4][value]'>
                                    <label>bonne réponse</label>
                                    </div>
                                    </div>",

                            ],
                            'name'=>'Ajouter une question',
                            'id' => 'add_question_link'
                        ]]
                ]
            ],

        ];
        }

        public function updateForm(){
            $list = [
                "config" => [
                    "method" => "POST",
                    "action" => "",
                    "submit" => "Ajouter un QCM",
                    "id" => "form_update_qcm",
                    "class" => 'form',
                ],
                "div" =>[
                    [
                        "id" => 'title',
                        "input" => [
                            'qcm_title'=>[
                                "id" => "qcm_title",
                                "label" => 'Titre du QCM',
                                "type" => "text",
                                "placeholder" => "Titre",
                                "required" => true,
                                "value" =>$this->getTitle()
                            ],
                        ],
                        "select" =>[],
                        "a"=>[

                        ]
                    ],

                ],

            ];
            $index = 1;
            foreach($this->getQuestions() as $question){
                $question_list = [
                    "id" => "question_".$index,
                    "input" => [
                        "Question".$index."[question]" =>[
                            "id" => "Question_".$index."_question",
                            "class" => "question",
                            "label" => 'Question',
                            "type" => "text",
                            "placeholder" => "Question",
                            "required" => true,
                            "value"=> $question->getQuestionContent()
                        ],
                        "Question".$index."[status]" =>[
                            "id" => "Question_".$index."_status",
                            "class" => "question-status",
                            "label" => 'Activé',
                            "type" => "checkbox",
                        ],
                    ],
                    "select"=>[],
                    "a"=>[
                        "remove-question" =>[
                            'name'=>'X',
                            'class' => 'remove-question',
                            'data' => [
                               "remove"=>"question_".$index
                            ]
                        ]
                    ]
                ];
                if($question->getStatus() == 1){
                    $question_list['input']["Question".$index."[status]"]["checked"] = true;
                }
                $reponse_index = 1;
                foreach($question->getPossibleAnswers() as $reponse){
                    $question_list["input"]["Question"]["reponse"] = [
                        "id" => "Question_".$index."_reponse".$reponse_index."_reponse",
                        "type" => 'text',
                        "class"=> 'answer',
                        'label' => 'Réponse n°'.$reponse_index,
                        "placeholder" => "Votre réponse",
                        "value" => $reponse->getAnswerContent()
                    ];
                     $question_list["input"]["Question"]["reponse"]["value"] = [
                        "id" => "Question_".$index."_reponse4_value",
                        "type" => "checkbox",
                        "class"=> 'answer',
                        'label' => 'bonne réponse',
                    ];
                     if($reponse->getGoodResponse() == 1){
                         $question_list["input"]["Question".$index."[reponse".$reponse_index."][value]"]["checked"] = true;
                     }
                    $reponse_index += 1;
                }
                $index += 1;
                $list["div"][] = $question_list;
            }
            $list["div"][]= [
                "id" => 'add_question',
                "input" => [],
                "select" =>[

                ],
                "a"=>[
                    "add_question" =>[
                        "data"=>[
                            "question"=>"<div id='question___index__'><div id='Question___index___question' class='question'>        
                                    <label>Question</label>
                                    <input type='text'name='Question__index__[question]'placeholder='Question' required='required'>
                                    </div><div id='Question___index___reponse1_reponse' class='answer'>
                                    <label>Réponse n°1</label>
                                    <input type='text'name='Question__index__[reponse1][reponse]'placeholder='Votre réponse'>
                                    </div><div id='Question___index___reponse1_value' class='answer' >
                                    <input type='checkbox'name='Question__index__[reponse1][value]'>
                                    <label>bonne réponse</label>
                                    </div><div id='Question___index___reponse2_reponse' class='answer'>
                                    <label>Réponse n°2</label>
                                    <input type='text'name='Question__index__[reponse2][reponse]'placeholder='Votre réponse'>
                                    </div><div id='Question___index___reponse2_value' class='answer'>
                                    <input type='checkbox'name='Question__index__[reponse2][value]'>
                                    <label>bonne réponse</label>
                                    </div><div id='Question___index___reponse3_reponse' class='answer'>
                                    <label>Réponse n°3</label>
                                    <input type='text'name='Question__index__[reponse3][reponse]'placeholder='Votre réponse'>
                                    </div><div id='Question___index___reponse3_value' class='answer' >
                                    <input type='checkbox'name='Question__index__[reponse3][value]'>
                                    <label>bonne réponse</label>
                                    </div><div id='Question___index___reponse4_reponse' class='answer'>
                                    <label>Réponse n°4</label>
                                    <input type='text'name='Question__index__[reponse4][reponse]'placeholder='Votre réponse'>
                                    </div><div id='Question___index___reponse4_value' class='answer'>
                                    <input type='checkbox'name='Question__index__[reponse4][value]'>
                                    <label>bonne réponse</label>
                                    </div>
                                    </div>",

                        ],
                        'name'=>'Ajouter une question',
                        'id' => 'add_question_link'
                    ]
                ]
            ];
            return $list;
        }

        public function listQcmTable()
        {
            $user = new User();

            //si user est professeur, on récupère uniquement les qcms qu'il a créés
            if($user->isProfessor())
            {
                //qcms liés au professeur connecté
                $queryConditions = [
                    "select"=>[
                        "qcm.*"
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

                $qcm = new Qcm();
                $qcms = $qcm->getAll($queryConditions);
            }
            //si user est admin, on récupère tous les cours
            elseif($user->isAdmin())
            {
                $qcm = new Qcm();
                $qcms = $qcm->getAll();
            }

            //création tableau à fournir au modal
            $arrayQcms = [];

            foreach($qcms as $qcm)
            {

                /**
                 * @var Qcm $qcm
                 */

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
                        "clause"=>"`status`.`id` = '".$qcm->getStatus()."'",
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

                //récupération du user qui a créé le qcm
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
                        "clause"=>"`user`.`id` = '".$qcm->getId_user()."'",
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

                $idQcm = $qcm->getId();
                $arrayQcms[$idQcm]['title'] = $qcm->getTitle();
                $arrayQcms[$idQcm]['insertedDate'] = Helpers::europeanDateFormat($qcm->getInsertedDate());
                $arrayQcms[$idQcm]['creator'] = Helpers::cleanFirstname($targetedUser->getFirstname()).' '.Helpers::cleanLastname($targetedUser->getLastname());
                $arrayQcms[$idQcm]['status'] = $targetedStatus->getName();
                $arrayQcms[$idQcm]['actions']['edit']['path'] = 'qcm/update/'.$idQcm;
                $arrayQcms[$idQcm]['actions']['edit']['icon'] = 'build';
                $arrayQcms[$idQcm]['actions']['edit']['color'] = 'blue';

                //changement du bouton en fonction du statut du user : si activé, on affiche le bouton de désactivation
                if($qcm->getStatus() == 1)
                {
                    $arrayQcms[$idQcm]['actions']['delete']['path'] = 'qcm/delete/'.$idQcm;
                    $arrayQcms[$idQcm]['actions']['delete']['icon'] = 'close';
                    $arrayQcms[$idQcm]['actions']['delete']['color'] = 'red';
                }
                //sinon on affiche le bouton d'activation
                elseif($qcm->getStatus() == 0)
                {
                    $arrayQcms[$idQcm]['actions']['delete']['path'] = 'qcm/activate/'.$idQcm;
                    $arrayQcms[$idQcm]['actions']['delete']['icon'] = 'check';
                    $arrayQcms[$idQcm]['actions']['delete']['color'] = 'green';
                }
            }

            return [
                "thead" => [
                    "Titre",
                    "Date d'ajout",
                    "Créateur",
                    "Statut",
                    "Actions"
                ],
                "content" => $arrayQcms
            ];
        }


        
    }