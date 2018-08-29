<?php
    class Possible_answers extends BaseSQL
    {
        protected $id = null;
        protected $answer_content;
        protected $goodResponse;
        protected $insertedDate;
        protected $updatedDate;
        protected $id_question;

        public function __construct()
        {
            parent::__construct();
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setAnswerContent($answer_content)
        {
            $this->answer_content = $answer_content;
        }

        public function setGoodResponse($goodResponse)
        {
            $this->goodResponse = $goodResponse;
        }

        public function setId_question($id_question)
        {
            $this->id_question = $id_question;
        }

        public function setInsertedDate($insertedDate)
        {
            $this->insertedDate = $insertedDate;
        }

        public function setUpdatedDate($updatedDate)
        {
            $this->updatedDate = $updatedDate;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getAnswerContent()
        {
            return $this->answer_content;
        }

        public function getGoodResponse()
        {
            return $this->goodResponse;
        }

        public function getInsertedDate()
        {
            return $this->insertedDate;
        }

        public function getUpdatedDate()
        {
            return $this->updatedDate;
        }

        public function getId_question()
        {
            return $this->id_question;
        }
    }