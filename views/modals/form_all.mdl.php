<pre>
<?php print_r($errors);?>
</pre>


<div id="form">
    <form method="<?php echo $config["config"]["method"]?>" action="<?php echo $config["config"]["action"]?>">
        <div id="form_content">

            <?php
            foreach ($config["div"] as $div_config):
            echo "<div id='".$div_config['id']."'>";

            foreach ($div_config["input"] as $name => $params):?>

            <div <?php
            if(isset($params["id"])){
                echo "id='".$params["id"]."' ";
            }
            if(isset($params["class"])){
                echo "class='".$params["class"]."' ";
            }
            ?>>
                <?php if($params["type"] == "text" || $params["type"] == "email" || $params["type"] == "password" || $params["type"] == 'checkbox'):?>

            <?php if(isset($params["label"]) && $params['type'] != 'checkbox'): ?>
                <label><?php echo $params["label"]?></label>
            <?php endif?>
                <input
                        type='<?php echo $params["type"]."'";
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

                        ?>
                    <?php echo (isset($params["required"]))?"required='required'":"";?>
            >
            <?php if(isset($params["label"]) && ($params['type'] == 'checkbox' || $params['type'] == 'radio') ): ?>
                <label><?php echo $params["label"]?></label>
            <?php endif?>
            <br>

        <?php endif;?>

        <?php endforeach;?>

        <?php foreach($div_config["select"] as $name=>$params):?>

            <?php if(isset($params["label"])): ?>
                <label><?php echo $params["label"]?></label>
            <?php endif?>
            <select>
            <?php foreach($params["options"] as $option):?>
                <option value='<?php echo $option["value"]."' > ".$option["name"];?></option>
            <?php endforeach ?>
                </select>

            <?php endforeach?>

                <?php foreach($div_config["a"] as $name=>$params):?>

                <a href="#" class="<?php
                echo $name."' ";
                if (isset($params["data"])){
                    foreach($params['data'] as $dataName => $dataValue){
                        echo 'data-'.$dataName."=\"".$dataValue."\" ";
                    }
                }
                if (isset($params['id'])){
                    echo "id='".$params['id']."'";
                }
                ?>><?php echo $params["name"]?></a>

            </div>';
            <?php endforeach;
                endforeach?>

        <div id="more_questions"> </div>
            <div>
                <input type="submit" value="<?php echo $config["config"]["submit"];?>">
            </div>
        </div>
    </form>
