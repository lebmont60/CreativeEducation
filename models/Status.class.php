<?php
    class Status extends BaseSQL
    {
        protected $id = null;
        protected $name;

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

        public function getId()
        {
            return $this->id;
        }

        public function getName()
        {
            return htmlspecialchars($this->name);
        }
    }