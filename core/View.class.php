<?php
	class View
	{
		private $v;
		private $t;
		private $data = [];

		public function __construct($v = "front-home", $t = "front")
		{
			$this->v = $v.".view.php";
			$this->t = $t.".tpl.php";

			if(!file_exists("views/templates/".$this->t))
			{
				die("Le template ".$this->t." n'existe pas");
			}

			if(!file_exists("views/".$this->v))
			{
				die("La vue ".$this->v." n'existe pas");
			}
		}

		public function assign($key, $value)
		{
			$this->data[$key] = $value;
		}

		public function addModal($modal, $config, $errors = [], $fieldValues = null)
		{
			include "views/modals/".$modal.".mdl.php";
		}

		public function __destruct()
		{
			global $c, $a;
			//permet de créer des variables depuis le tableau data
			extract($this->data);
			include "views/templates/".$this->t;
		}
	}