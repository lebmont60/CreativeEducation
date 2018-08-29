<?php
    class Course_group_link extends BaseSQL
    {
        protected $id = null;
        protected $id_course;
        protected $id_user_group;

        public function __construct()
        {
            parent::__construct();
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setId_course($id_course)
        {
            $this->id_course = $id_course;
        }

        public function setId_user_group($id_user_group)
        {
            $this->id_user_group = $id_user_group;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getId_course()
        {
            return $this->id_course;
        }

        public function getId_user_group()
        {
            return $this->id_user_group;
        }
    }