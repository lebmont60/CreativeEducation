<form method="<?php echo $config['config']['method']?>" 
      action="<?php echo ($config['config']['action'] != '') ? DIRNAME.$config['config']['action'] : ''; ?>"
      enctype="<?php echo (isset($config['config']['enctype'])) ? $config['config']['enctype'] : 'application/x-www-form-urlencoded'; ?>"
      class="form-horizontal">

    <?php foreach($config['input'] as $name => $params):
    
        if($name == "captcha"):

            continue;

        endif;

        if($params['type'] == 'text' || $params['type'] == 'email' || $params['type'] == 'password'): ?>
            
            <div class="row">
                <label class="col-md-2 label-on-left"><?php echo $params['placeholder']; ?></label>
                <div class="col-md-10">
                    <div class="form-group is-empty">
                        <input 
                            type="<?php echo $params['type'];?>" 
                            name="<?php echo $name;?>" 
                            class="form-control" 
                            <?php echo (isset($params['required']) && $params['required']) ? "required='required'" : "";
                                  echo (isset($fieldValues[$name])) ? ' value="'.$fieldValues[$name].'" ' : ""; ?>

                        >
                    </div>
                </div>
            </div>

        <?php elseif($params['type'] == 'file'): ?>

            <div class="row">
                <label class="col-md-2 label-on-left"><?php echo $params['placeholder']; ?></label>
                <div class="col-md-10">
                    <div class="form-group is-empty">
                        <input 
                            type="<?php echo $params['type'];?>" 
                            name="<?php echo $name;?>" 
                            <?php echo (isset($params['required']) && $params['required']) ? "required='required'" : ""; ?>

                        >
                    </div>
                </div>
            </div>

        <?php endif;

    endforeach;

    if(isset($config['select'])):

        foreach($config['select'] as $name => $params): ?>

            <div class="row">
                <label class="col-md-2 label-on-left"><?php echo $params['placeholder']; ?></label>
                <div class="col-md-10">
                    <div class="form-group is-empty">
                        <select name="<?php echo $name; echo (isset($params['multiple']) && $params['multiple']) ? "[]" : ""; ?>" 
                                <?php echo (isset($params['required']) && $params['required']) ? "required='required'" : ""; 
                                echo (isset($params['multiple']) && $params['multiple']) ? "multiple" : ""; ?> 
                                class="form-control">
                            
                            <?php if($params['emptyOption']): ?>

                                <option value=""></option>

                            <?php endif; 

                            if(is_array($fieldValues[$name])):

                                foreach($params['options'] as $id => $value):

                                    $selected = (in_array($id, $fieldValues[$name])) ? ' selected ' : ''; ?>

                                    <option value="<?php echo $id; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>

                                <?php endforeach;

                            else:

                                foreach($params['options'] as $id => $value):

                                    $selected = ($id == $fieldValues[$name]) ? ' selected ' : ''; ?>

                                    <option value="<?php echo $id; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>

                                <?php endforeach;

                            endif; ?>

                        </select>
                    </div>
                </div>
            </div>

        <?php endforeach;

    endif;

    if(isset($config['textarea'])):

        foreach($config['textarea'] as $name => $params): ?>

            <div class="row">
                <label class="col-md-2 label-on-left"><?php echo $params['placeholder']; ?></label>
                <div class="col-md-10">
                    <div class="form-group is-empty">
                        <textarea
                            name="<?php echo $name; ?>"
                            rows="<?php echo $params['rows']; ?>"
                            class="form-control"
                            <?php echo (isset($params['required']) && $params['required']) ? "required='required'" : "";?>
                        ><?php echo (isset($fieldValues)) ? $fieldValues[$name] : ""; ?></textarea>
                    </div>
                </div>
            </div>

        <?php endforeach;

    endif;

    if($config['captcha']): ?>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group is-empty">
                    <label class="control-label"></label>
                    <img src="<?php echo DIRNAME.'public/captcha/captcha.php'; ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 label-on-left"><?php echo $config['label'][$maxIdx - 1]; ?></label>
            <div class="col-md-10">
                <div class="form-group is-empty">
                    <label class="control-label"></label>
                    <input 
                        type="<?php echo $config['input']['captcha']['type']; ?>" 
                        name="<?php echo $name;?>"
                        placeholder="<?php echo $config['input']['captcha']['placeholder'];?>"
                        <?php echo (isset($config['input']['captcha']['required']) && $config['input']['captcha']['required']) ? "required='required'" : ""; ?>
                    >
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-button form-button-center">
                <button name="button" type="submit" class="btn btn-fill btn-rose pull-right"><?php echo $config['button']['text']; ?></button>
            </div>
        </div>
    </div>

</form>