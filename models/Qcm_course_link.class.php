<?php
    class Qcm_course_link extends BaseSQL
    {
        protected $id_course;
        protected $id_qcm;

        public function __construct()
        {
            parent::__construct();
        }

        public function setId_course($id_course)
        {
            $this->id_course = $id_course;
        }

        public function setId_qcm($id_qcm)
        {
            $this->id_qcm = $id_qcm;
        }

        public function getId_course()
        {
            return $this->id_course;
        }

        public function getId_qcm()
        {
            return $this->id_qcm;
        }
    }