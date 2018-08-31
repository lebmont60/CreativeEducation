<?php


class Question extends BaseSQL
{
    protected $id = null;
    protected $question_content;
    protected $insertedDate;
    protected $updatedDate;
    protected $status;
    protected $possible_answers;
    protected $id_qcm;

    public function __construct()
    {
        parent::__construct();
        $this->possible_answers = [];
        $this->foreign_keys = ['Possible_answers'];
        $this->parent_key = 'id_qcm';
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

    public function setStatus($status){
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQuestionContent()
    {
        return $this->question_content;
    }

    /**
     * @return mixed
     */
    public function getInsertedDate()
    {
        return $this->insertedDate;
    }

    /**
     * @return mixed
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    public function getStatus()
    {
        return $this->status;
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