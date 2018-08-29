<?php
    class Answer extends BaseSQL
    {
        protected $id_qcm;
        protected $id_user;
        protected $id_possible_answers;

        public function __construct()
        {
            parent::__construct();
        }

        public function setId_qcm($id_qcm)
        {
            $this->id_qcm = $id_qcm;
        }

        public function setId_user($id_user)
        {
            $this->id_user = $id_user;
        }

        public function setId_possible_answers($id_possible_answers)
        {
            $this->id_possible_answers = $id_possible_answers;
        }

        public function getId_qcm()
        {
            return $this->id_qcm;
        }

        public function getId_user()
        {
            return $this->id_user;
        }

        public function getId_possible_answers()
        {
            return $this->id_possible_answers;
        }
    }