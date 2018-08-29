<?php
    class Role_qcm_link extends BaseSQL
    {
        protected $id_qcm;
        protected $id_role;

        public function __construct()
        {
            parent::__construct();
        }

        public function setId_qcm($id_qcm)
        {
            $this->id_qcm = $id_qcm;
        }

        public function setId_role($id_role)
        {
            $this->id_role = $id_role;
        }

        public function getId_qcm()
        {
            return $this->id_qcm;
        }

        public function getId_role()
        {
            return $this->id_role;
        }
    }