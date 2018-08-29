<?php



class QcmController
{

    public function indexAction($params){

    }

    public function addAction($params){

        if(count($params['POST']) != count(array_filter($params['POST'])) || empty($params['POST']))
        {
            $qcm = new Qcm;
            $form = $qcm->addForm();
            $v = new View("back-addqcm", "back");
            $v->assign("config", $form);
            $v->assign("errors", '');
            $v->assign("name", 'toto');
        }
        else
        {
            $qcm = new Qcm();

            $qcm->setTitle($params["POST"]['qcm_title']);
            $qcm->setStatus(1);
            $qcm->setId_user($_SESSION['user']['id']);
            $date_create = date_format(new DateTime(),'Y-m-d');
            $qcm->setInsertedDate($date_create);
            $qcm->setUpdatedDate($date_create);
            unset($params["POST"]['qcm_title']);
            foreach ($params['POST'] as $question){
                $new_question = new Question();
                $new_question->setQuestionContent($question['question']);
                unset($question['question']);
                foreach($question as $answer){
                    $possible_answer = new Possible_answers();
                    $possible_answer->setAnswerContent($answer['reponse']);
                    $possible_answer->setInsertedDate($date_create);
                    $possible_answer->setUpdatedDate($date_create);
                    if(isset($answer['value'])){
                        $possible_answer->setGoodResponse(1);
                    }else {
                        $possible_answer->setGoodResponse(0);
                    }
                    $new_question->addPossibleAnswer($possible_answer);
                }
                $qcm->addQuestion($new_question);
            }
            $qcm->save();exit;

            header('Location: '.DIRNAME.'index/home');
        }
    }

    public function updateAction($params){
        if(!empty($params['POST']))
        {

        } else {
            //id du qcm à modifier
            $id = $params['URL'][0];

            $qcm = new Qcm();

            $queryConditions = [
                'select'=>[
                    '*'
                ],
                'join'=>[
                    'inner_join'=>[],
                    'left_join'=>[],
                    'right_join'=>[]
                ],
                'where'=>[
                    'clause'=>'`qcm`.`id` = '.$id,
                    'and'=>[],
                    'or'=>[]
                ],
                'and'=>[
                    [
                        'clause'=>'',
                        'and'=>[],
                        'or'=>[]
                    ]
                ],
                'or'=>[
                    [
                        'clause'=>'',
                        'and'=>[],
                        'or'=>[]
                    ]
                ],
                'group_by'=>[],
                'having'=>[
                    'clause'=>'',
                    'and'=>[],
                    'or'=>[]
                ],
                'order_by'=>[
                    'asc'=>[],
                    'desc'=>[]
                ],
                'limit'=>[
                    'offset'=>'',
                    'range'=>''
                ]
            ];

            $qcm = new Qcm();
            $targetedQcm = $qcm->getAll($queryConditions);
            //var_dump($targetedQcm[0]->getQuestion());
            //exit;
            $form = $targetedQcm[0]->updateForm();

            $v = new View("back-updateqcm", "back");
            $v->assign("config", $form);
            $v->assign("errors", '');
        }
    }


}