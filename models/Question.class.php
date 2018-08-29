<?php


class Question extends BaseSQL
{
    protected $id = null;
    protected $question_content;
    private $insertedDate;
    private $updatedDate;
    protected $possible_answers;
    protected $id_qcm;

    public function __construct()
    {
        parent::__construct();
        $this->possible_answers = [];
        $this->foreign_keys = ['possible_answers'];
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setQuestionContent($question_content)
    {
        $this->question_content = $question_content;
    }

    public function setIdQcm($id_qcm)
    {
        $this->id_qcm = $id_qcm;
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

    public function getQuestionContent()
    {
        return $this->question_content;
    }

    public function getIdQcm()
    {
        return $this->id_qcm;
    }

    public function getPossibleAnswers(){
        return $this->possible_answers;
    }

    public function setPossibleAnswers($possible_answers){
        $this->possible_answers = $possible_answers;
    }

    public function addPossibleAnswer($possible_answer){
        $this->possible_answers[]=$possible_answer;
    }

    public function removePossibleAnswer($possible_answer){
        $cle = array_search($possible_answer, $this->possible_answers);
        unset($this->possible_answers[$cle]);
        $this->possible_answers = array_values($this->possible_answers);

    }

}