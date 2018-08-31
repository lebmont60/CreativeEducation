<?php



class QcmController
{

    /**
     * @param $params
     */
    public function indexAction($params){
        $user = new User();

        //vérification user connecté
        if($user->isConnected())
        {
            //vérification user admin
            if($user->isAdmin() || $user->isProfessor())
            {
                $qcm = new Qcm();
                //tableau des cours
                $list_qcm = $qcm->listQcmTable();
                $v = new View("back-qcm", "back");
                $v->assign('config', $list_qcm);
            }
            //sinon on le renvoie la home
            else
            {
                header('Location: '.DIRNAME.'index/home');
            }
        }
        //sinon on renvoie vers la page de login
        else
        {
            header('Location: '.DIRNAME.'index/login');
        }
    }

    /**
     * @param $params
     */
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
            $date_create = date_format(new DateTime(),'Y-m-d H:i:s');
            $qcm->setInsertedDate($date_create);
            $qcm->setUpdatedDate($date_create);
            unset($params["POST"]['qcm_title']);
            foreach ($params['POST'] as $question){
                $new_question = new Question();
                $new_question->setQuestionContent($question['question']);
                $new_question->setStatus(1);
                $date_create = date_format(new DateTime(),'Y-m-d H:i:s');
                $new_question->setInsertedDate($date_create);
                $new_question->setUpdatedDate($date_create);
                unset($question['question']);
                foreach($question as $answer){
                    $possible_answer = new Possible_answers();
                    $possible_answer->setAnswerContent($answer['reponse']);
                    $date_create = date_format(new DateTime(),'Y-m-d H:i:s');
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
            $qcm->save();
            header('Location: '.DIRNAME.'qcm/');
        }
    }

    public function updateAction($params){
        if(!empty($params['POST']))
        {
            var_dump($params['POST']);
            $qcm = new Qcm();
            $queryConditions = [
                'select'=>[
                    '*'
                ],
                'where'=>[
                    'clause'=>'`qcm`.`id` = '.$params['URL'][0],
                    'and'=>[],
                    'or'=>[]
                ],
            ];
            /**
             * @var Qcm $targetedQcm
             */
            $targetedQcm =$qcm->getAll($queryConditions)[0];
            var_dump($targetedQcm);
            $targetedQcm->setTitle($params['POST']['qcm_title']);
            $date_updated = date_format(new DateTime(),'Y-m-d H:i:s');
            $targetedQcm->setUpdatedDate($date_updated);
            unset($params['POST']['qcm_title']);
            $questions = $targetedQcm->getQuestions();
            for ($i = 0; $i < count($params['POST']); $i++ ) {
                $question = $params['POST']['Question'.($i+1)];
                $questions[$i]->setQuestionContent($question['question']);
                if(isset($question['status'])){
                    $questions[$i]->setStatus(1);
                    unset($question['status']);
                } else {
                    $questions[$i]->setStatus(0);
                }
                $questions[$i]->setUpdatedDate($date_updated);
                unset($question["question"]);
                $list_answer = $questions[$i]->getPossibleAnswers();
                for($j = 0; $j < count($list_answer); $j++){
                    var_dump('reponse'.($j+1));
                    $answer = $question['reponse'.($j+1)];
                    $list_answer[$j]->setAnswerContent($answer['reponse']);
                    $list_answer[$j]->setUpdatedDate($date_updated);
                    if(isset($answer['value'])){
                        $list_answer[$j]->setGoodResponse(1);
                    }else {
                        $list_answer[$j]->setGoodResponse(0);
                    }
                }
                unset($question);
            }
            foreach ($params['POST'] as $question){
                $new_question = new Question();
                $new_question->setQuestionContent($question['question']);
                $new_question->setStatus(1);
                $date_create = date_format(new DateTime(),'Y-m-d H:i:s');
                $new_question->setInsertedDate($date_create);
                $new_question->setUpdatedDate($date_create);
                unset($question['question']);
                foreach($question as $answer){
                    $possible_answer = new Possible_answers();
                    $possible_answer->setAnswerContent($answer['reponse']);
                    $date_create = date_format(new DateTime(),'Y-m-d H:i:s');
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
            $qcm->save();
            var_dump($targetedQcm);


        } else {
            //id du qcm à modifier
            $id = $params['URL'][0];

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
            $form = $targetedQcm[0]->updateForm();

            $_SESSION['qcm'] = $targetedQcm[0];
            $v = new View("back-updateqcm", "back");
            $v->assign("config", $form);
            $v->assign("errors", '');
        }
    }
}