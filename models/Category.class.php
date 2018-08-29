<?php
    class Category extends BaseSQL
    {
        protected $id = null;
        protected $name;
        protected $status;
        protected $insertedDate;
        protected $updatedDate;
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
    }