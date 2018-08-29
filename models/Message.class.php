<?php
    class Message extends BaseSQL
    {
        protected $id = null;
        protected $content;
        protected $status;
        protected $insertedDate;
        protected $updatedDate;
        protected $id_user;
        protected $id_thread;

        public function __construct()
        {
            parent::__construct();
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setContent($content)
        {
            $this->content = $content;
        }

        public function setStatus($status)
        {
            $this->status = $status;
        }

        public function setId_user($id_user)
        {
            $this->id_user = $id_user;
        }

        public function setId_thread($id_thread)
        {
            $this->id_thread = $id_thread;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getContent()
        {
            return $this->content;
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

        public function getId_thread()
        {
            return $this->id_thread;
        }
    }