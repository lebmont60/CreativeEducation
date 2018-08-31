<?php
class BaseSQL
{
    private $pdo;
    private $table;
    private $columns;
    protected $foreign_keys;
    protected $parent_key;

    public function __construct()
    {
        try
        {
            $this->pdo = new PDO(DBDRIVER.":host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPWD);
            $this->pdo->exec("SET CHARACTER SET utf8");
        }
        catch(Exception $e)
        {
            //die("Erreur SQL : ".$e->getMessage());
            header('Location: '.DIRNAME.'error/500');
        }

        $this->table = strtolower(get_called_class());
    }

    public function setColumns()
    {
        $this->columns = array_diff_key(get_object_vars($this), get_class_vars(get_class()));
    }

    public function save($foreignKey = [])
    {
        $this->setColumns();

        if($this->id)
        {
            //UPDATE
            $array_vars = [];
            foreach($this->columns as $key => $value) {
                if(is_array($value)){
                    foreach($value as $val){
                        $array_vars[] = $val;
                    }
                    unset($this->columns[$key]);
                } elseif(array_key_exists($key, $foreignKey)){
                    $this->columns[$key] = $foreignKey[$key];
                } else{
                    $sqlSet[] = $key."=:".$key;
                }
            }

            $query = $this->pdo->prepare(" UPDATE ".$this->table." SET ".implode(", ", $sqlSet)." WHERE id=:id ");

            $query->execute($this->columns);

            $foreign_key_id = $this->columns['id'];

            foreach($array_vars as $var){
                $var->save(['id_'.$this->table=>$foreign_key_id]);
            }
        }
        else
        {
            //INSERT
            unset($this->columns['id']);
            $array_vars = [];
            $where_content='';
            foreach($this->columns as $key => $value){
                if(is_array($value)){
                    foreach($value as $val){
                        $array_vars[] = $val;
                    }
                    unset($this->columns[$key]);
                } elseif(array_key_exists($key, $foreignKey)){
                    $this->columns[$key] = $foreignKey[$key];
                    $where_content .= ' AND '.$key."='".$foreignKey[$key]."'";
                } else{
                    if($where_content == ''){
                        $where_content .= ' '.$key."='".$value."'";
                    }else{
                        $where_content .= ' AND '.$key."='".$value."'";
                    }
                }
            }
            $query = $this->pdo->prepare("INSERT INTO ".$this->table." (`". implode("`, `", array_keys($this->columns)) ."`)
                                              VALUES (:". implode(", :", array_keys($this->columns)) .")");
            $query->execute($this->columns);

            $queryConditions = [
                'select'=>[
                    $this->table.'.*'
                ],
                'join'=>[
                    'inner_join'=>[],
                    'left_join'=>[],
                    'right_join'=>[]
                ],
                'where'=>[
                    'clause'=>$where_content,
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
            $foreign_key_id = $this->getAll($queryConditions)[0];
            $foreign_key_id = $foreign_key_id->getId();

            foreach($array_vars as $var){
                $var->save(['id_'.$this->table=>$foreign_key_id]);
            }
        }
    }

    public function delete($id)
    {
        $query = $this->pdo->prepare("DELETE FROM " . $this->table . " 
                                          WHERE `" . $this->table . "`.`id` = '" . $id . "'");

        $query->execute();
    }

    public function getAll($conditions = null)
    {

        //dans le cas où l'on souhaite récupérer tout le contenu de la table
        if($conditions === null)
        {
            $query = $this->pdo->prepare("SELECT *
                                              FROM ".$this->table);
        }
        //dans le cas où on veut seulement certaines données via clauses WHERE etc
        else
        {
            if (isset($conditions['select']) && !empty($conditions['select'])){
                //SELECT
                $sqlSet = "SELECT ".implode(', ', $conditions['select']);
                //FROM
                $sqlSet .= " FROM ".$this->table." ";
            } else {
                $sqlSet = "SELECT * FROM ".$this->table;
            }

            if (isset($conditions['join']) && !empty($conditions['join'])) {
                //INNER JOIN - LEFT JOIN - RIGHT JOIN
                foreach ($conditions['join'] as $type => $joinsByType) {
                    if (count($conditions['join'][$type]) > 0) {
                        foreach ($joinsByType as $join) {
                            $sqlSet .= strtoupper(preg_replace('/_/', ' ', $type)) . " " . $join . " ";
                        }
                    }
                }
            }
            if(isset($conditions['where']) && !empty($conditions['where'])) {
                //WHERE
                if ($conditions['where']['clause'] != '') {
                    $sqlSet .= " WHERE (" . $conditions['where']['clause'];
                    if (isset($conditions['where']['and']) && !empty($conditions['where']['and'])) {
                        foreach ($conditions['where']['and'] as $andCondition) {
                            $sqlSet .= " AND " . $andCondition;
                        }
                    }
                    if (isset($conditions['where']['and']) && !empty($conditions['where']['and'])) {
                        foreach ($conditions['where']['or'] as $orCondition) {
                            $sqlSet .= " OR " . $orCondition;
                        }
                    }
                    $sqlSet .= ")";
                }
            }
            if(isset($conditions['and']) && !empty($conditions['and'])) {
                //AND
                if ($conditions['and'][0]['clause'] != '') {
                    foreach ($conditions['and'] as $andClause) {
                        $sqlSet .= " AND (" . $andClause['clause'];
                        if (count($andClause['and']) > 0) {
                            foreach ($andClause['and'] as $andCondition) {
                                $sqlSet .= " AND " . $andCondition;
                            }
                        }
                        if (count($andClause['or']) > 0) {
                            foreach ($andClause['or'] as $orCondition) {
                                $sqlSet .= " OR " . $orCondition;
                            }
                        }
                        $sqlSet .= ")";
                    }
                }
            }
            if(isset($conditions['or']) && !empty($conditions['or'])) {
                //OR
                if ($conditions['or'][0]['clause'] != '') {
                    foreach ($conditions['or'] as $orClause) {
                        $sqlSet .= " OR (" . $orClause['clause'];
                        if (count($orClause['and']) > 0) {
                            foreach ($orClause['and'] as $andCondition) {
                                $sqlSet .= " AND " . $andCondition;
                            }
                        }
                        if (count($orClause['or']) > 0) {
                            foreach ($orClause['or'] as $orCondition) {
                                $sqlSet .= " OR " . $orCondition;
                            }
                        }
                        $sqlSet .= ")";
                    }
                }
            }
            if(isset($conditions['group_by']) && !empty($conditions['group_by'])) {
                //GROUP BY
                if (count($conditions['group_by']) > 0) {
                    $sqlSet .= " GROUP BY " . implode(', ', $conditions['group_by']);
                }
            }
            if(isset($conditions['having']) && !empty($conditions['having'])) {
                //HAVING
                if (isset($conditions['having']['and']) && !empty($conditions['having']['and'])) {
                    $sqlSet .= " HAVING " . $conditions['having']['clause'];
                    if (count($conditions['having']['and']) > 0) {
                        foreach ($conditions['having']['and'] as $andCondition) {
                            $sqlSet .= " AND " . $andCondition;
                        }
                    }
                    if (isset($conditions['having']['or']) && !empty($conditions['having']['or'])) {
                        foreach ($conditions['having']['or'] as $orCondition) {
                            $sqlSet .= " OR " . $orCondition;
                        }
                    }
                }
            }
            if(isset($conditions['order_by']) && !empty($conditions['order_by'])) {
                //ORDER BY
                if (count($conditions['order_by']['asc']) > 0) {
                    $sqlSet .= " ORDER BY " . implode(' ASC, ', $conditions['order_by']['asc']) . " ASC";
                }
                if (count($conditions['order_by']['desc']) > 0) {
                    if (count($conditions['order_by']['asc']) == 0) {
                        $sqlSet .= " ORDER BY ";
                    } else {
                        $sqlSet .= ", ";
                    }
                    $sqlSet .= implode(' DESC, ', $conditions['order_by']['desc']) . " DESC";
                }
            }
            //LIMIT
            if(isset($conditions['limit']) && !empty($conditions['limit'])) {
                if ($conditions['limit']['offset'] != '' || $conditions['limit']['range'] != '') {
                    $sqlSet .= " LIMIT ";
                    if ($conditions['limit']['offset'] != '') {
                        $sqlSet .= $conditions['limit']['offset'];
                    }
                    if ($conditions['limit']['range'] != '') {
                        $sqlSet .= ", " . $conditions['limit']['range'];
                    }
                }
            }
            $query = $this->pdo->prepare($sqlSet);

        }

        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_CLASS, $this->table);
        if($conditions == null || !isset($conditions['select']) || empty($conditions['select']) || $conditions['select'][0] == '*' || $conditions['select'][0] == $this->table.'.*'){
            $foreign_array = [];
            foreach($results as $result){
                $result_id = $result->getId();
                if(isset($this->foreign_keys) ){
                    foreach ($this->foreign_keys as $foreign_key){
                        $foreign_entity = new $foreign_key();
                        $foreign_array = $foreign_entity->getAll([
                            'where'=>[
                                'clause'=>'id_'.$this->table.' = '.$result_id
                            ]
                        ]);
                        $setter="set".str_replace(' ','',ucwords(str_replace('_',' ',$foreign_key)));
                        $result->$setter($foreign_array);
                    }
                }

            }
        }
        return $results;
    }
}
