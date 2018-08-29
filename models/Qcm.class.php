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
            $this->foreign_keys = ['question'];
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

        public function getQuestion(){
            return $this->question;
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
                "action" => "add",
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
                            'id' => 'add_question'
                        ]
                    ]
                ]
            ],

        ];
        }

        public function updateForm(){
            $list = [
                "config" => [
                    "method" => "POST",
                    "action" => "update",
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
                        "a"=>[]
                    ],

                ],

            ];
            $index = 1;
            foreach($this->getQuestion() as $question){
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
                    ],
                    "select"=>[],
                    "a"=>[
                        "remove-question" =>[
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
                            'name'=>'X',
                            'class' => 'remove-question'
                        ]
                    ]
                ];
                $reponse_index = 1;
                foreach($question->getPossibleAnswers() as $reponse){
                    $question_list["input"]["Question".$reponse_index."[reponse4][reponse]"] = [
                        "id" => "Question_".$index."_reponse4_reponse",
                        "type" => 'text',
                        "class"=> 'answer',
                        'label' => 'Réponse n°4',
                        "placeholder" => "Votre réponse",
                        "value" => $reponse->getAnswerContent()
                    ];
                     $question_list["input"]["Question".$reponse_index."[reponse4][value]"] = [
                        "id" => "Question_".$index."_reponse4_value",
                        "type" => "checkbox",
                        "class"=> 'answer',
                        'label' => 'bonne réponse',
                    ];
                     if($reponse->getGoodResponse() == 1){
                         $question_list["input"]["Question".$reponse_index."[reponse4][value]"]["checked"] = true;
                     }
                    $reponse_index += 1;
                }
                $index += 1;
                $list["div"][] = $question_list;
            }
            return $list;
        }
    }