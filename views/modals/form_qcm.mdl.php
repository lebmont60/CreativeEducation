<pre>
<?php print_r($errors);?>
</pre>


<div id="form">
    <form id="<?php echo $config["config"]["id"]?>" method="<?php echo $config["config"]["method"]?>" action="<?php echo $config["config"]["action"]?>">
            <?php
            foreach ($config["div"] as $div_config){
                echo "<div ";
                if(isset($div_config['id'])){
                    echo "id='".$div_config['id']."'";
                }
                echo ">";
                foreach ($div_config["input"] as $name => $params){
                    echo "<div id='".$name."' ";
                    if(isset($params["class"])){
                        echo "class='".$params["class"]."' ";
                    }
                    if(isset($params["id"])){
                        echo "class='".$params["id"]."' ";
                    }
                    echo '>';
                    if($params["type"] == "text" || $params["type"] == "email" || $params["type"] == "password" || $params["type"] == 'checkbox'){
                        if(isset($params["label"]) && $params['type'] != 'checkbox'){
                            echo '<label>'.$params["label"].'</label>';
                        }
                        echo "<input type='".$params["type"]."'";
                        echo "name='".$name."'";
                        if(isset($params["placeholder"])){
                            echo "placeholder='".$params["placeholder"]."'";
                        }

                        if (isset($params["value"])){
                            echo "value ='".$params["value"]."'";
                        }

                        if (isset($params["data"])){
                            foreach($params['data'] as $dataName => $dataValue){
                                echo 'data-'.$dataName."='".$dataValue."' ";
                            }
                        }
                        if (isset($params['value'])){
                            echo "value ='".$params["value"]."'";
                        }
                        if(isset($params['checked'])){
                            echo ' checked ';
                        }
                        echo (isset($params["required"]))?"required='required'":"";
                        echo '>';
                        if(isset($params["label"]) && ($params['type'] == 'checkbox' || $params['type'] == 'radio') ){
                            echo "<label>".$params["label"]."</label>";
                        }
                    }
                    echo '</div>';
                }
                foreach($div_config['select'] as $name=>$params){
                    echo "<div id='".$name."' ";
                    if(isset($params["class"])){
                        echo "class='".$params["class"]."' ";
                    }
                    echo '>';
                    if(isset($params["label"])){
                        echo '<label>'.$params["label"].'</label>';
                    }
                    echo '<select>';
                    foreach($params['options'] as $option){
                        echo "<option value='".$option["value"]."' > ".$option["name"]."</option>";
                    }
                    echo '</select>';
                    echo '</div>';
                }
                foreach($div_config['a'] as $name=>$params){
                    echo "<div id='".$name."' ";
                    if(isset($params["class"])){
                        echo "class='".$params["class"]."' ";
                    }
                    echo '>';
                    echo "<a href='#' class='".$name."'";
                    if (isset($params["data"])){
                        foreach($params['data'] as $dataName => $dataValue){
                            echo 'data-'.$dataName."=\"".$dataValue."\" ";
                        }
                    }
                    if (isset($params['id'])){
                        echo "id='".$params['id']."'";
                    }
                    echo '>'.$params["name"].'</a>';
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
            <div> <input type='submit' value='<?php echo $config["config"]["submit"]?>'></div>
    </form>
</div>
