<form method="<?php echo $config['config']['method']?>" 
      action="<?php echo ($config['config']['action'] != '') ? DIRNAME.$config['config']['action'] : ''; ?>"
      enctype="<?php echo (isset($config['config']['enctype'])) ? $config['config']['enctype'] : 'application/x-www-form-urlencoded'; ?>"
      class="form-horizontal">

    <?php foreach($config['input'] as $name => $params):
    
        if($name == "captcha"):

            continue;

        endif;

        if($params['type'] == 'text' || $params['type'] == 'email' || $params['type'] == 'password'): ?>
            
            <div class="form-row">
                <i class="material-icons"><?php echo $params['icon']; ?></i>
                <input 
                    type="<?php echo $params['type'];?>" 
                    name="<?php echo $name;?>"
                    placeholder="<?php echo $params['placeholder'];?>"
                    <?php echo (isset($params['required']) && $params['required']) ? "required='required'" : "";
                          echo (isset($fieldValues[$name])) ? ' value="'.$fieldValues[$name].'" ' : ""; ?>
                >
            </div>

        <?php elseif($params['type'] == 'file'): ?>

            <div class="form-row">
                <i class="material-icons"><?php echo $params['icon']; ?></i>
                <input 
                    type="<?php echo $params['type'];?>" 
                    name="<?php echo $name;?>"
                    placeholder="<?php echo $params['placeholder'];?>"
                    <?php echo (isset($params['required']) && $params['required'])?"required='required'":""; ?>
                >
            </div>

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

            <div class="form-row">
                <i class="material-icons"><?php echo $params['icon']; ?></i>
                <select name="<?php echo $name; ?>">

                    <option value="" selected disabled><?php echo $params['placeholder']; ?></option>

                    <?php if($params['emptyOption']): ?>

                        <option value=""></option>

                    <?php endif; ?>

                    <?php foreach($params['options'] as $id => $value):

                        $selected = ($id == $fieldValues[$name]) ? ' selected ' : ''; ?>

                        <option value="<?php echo $id; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>

                    <?php endforeach; ?>

                </select>
            </div>

        <?php endforeach;

    endif;

    if(isset($config['captcha']) && $config['captcha']): ?>

        <div class="form-row captcha">
            <img src="<?php echo DIRNAME.'public/captcha/captcha.php'; ?>">
        </div>

        <div class="form-row">
            <i class="material-icons"><?php echo $config['input']['captcha']['icon']; ?></i>
            <input 
                type="<?php echo $config['input']['captcha']['type']; ?>" 
                name="<?php echo $name;?>"
                placeholder="<?php echo $config['input']['captcha']['placeholder'];?>"
                <?php echo (isset($config['input']['captcha']['required']) && $config['input']['captcha']['required']) ? "required='required'" : ""; ?>
            >
        </div>

    <?php endif;

    if(isset($config['forgotPassword']) && $config['forgotPassword']): ?>

        <div class="form-row forgotPassword">
            <a href="<?php echo DIRNAME.'index/forgottenPassword'; ?>">Mot de passe oublié ?</a>
        </div>

    <?php endif; ?>

    <div class="form-row">
        <button name="button" value="sendForm" class="btn btn-rose">
            <?php echo $config['button']['text']; ?>
            <span class="btn-label btn-label-right">
                <i class="material-icons"><?php echo $config['button']['icon']; ?></i>
            </span>
        </button>
    </div>

</form>