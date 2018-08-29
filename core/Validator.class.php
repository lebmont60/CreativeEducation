<?php
    class Validator
    {
        public static function validate($form, $paramsPost, $paramsFiles = null)
        {
            //initialisation tableau erreurs
            $errorsMsg = [];

            //parcours des inputs
            foreach($form["input"] as $name => $config)
            {
                if(isset($config["confirm"]) && $paramsPost[$name] !== $paramsPost[$config["confirm"]])
                {
                    $errorsMsg[] = $config['placeholder']." doit être identique à ".$form['input'][$config["confirm"]]['placeholder']."";
                }
                elseif(!isset($config["confirm"]))
                {
                    if($config["type"] == "email" && !self::checkEmail($paramsPost[$name]))
                    {    
                        $errorsMsg[] = $config['placeholder']." n'est pas valide";
                    }
                    elseif($config["type"] == "password" && !self::checkPwd($paramsPost[$name]))
                    {
                        $errorsMsg[] = $config['placeholder']." est incorrect (6 à 12, min, maj, chiffres)";
                    }
                }

                //gestion required pour les input qui ne sont pas de type file
                if($config['type'] != 'file' && isset($config["required"]) && $config["required"] && !self::minLength($paramsPost[$name], 1))
                {
                    $errorsMsg[] = $config['placeholder']." doit faire plus de 1 caractère";
                }
                //gestion pour les input file
                elseif($config['type'] == 'file' && isset($config["required"]) && $config["required"])
                {
                    if(isset($paramsFiles))
                    {
                        if($paramsFiles[$name]['size'] == 0 || $paramsFiles[$name]['error'] == 4)
                        {
                            $errorsMsg[] = $config['placeholder']." est vide"; 
                        }
                    }
                    else
                    {
                        $errorsMsg[] = $config['placeholder']." est vide";
                    }
                }

                if(isset($config["minString"]) && !self::minLength($paramsPost[$name], $config["minString"]))
                {
                    $errorsMsg[] = $config['placeholder']." doit faire plus de ".$config["minString"]." caractères";
                }

                if(isset($config["maxString"]) && !self::maxLength($paramsPost[$name], $config["maxString"]))
                {
                    $errorsMsg[] = $config['placeholder']." doit faire moins de ".$config["maxString"]." caractères";
                }

                //vérification captcha saisi
                if($name == 'captcha')
                {
                    if($paramsPost[$name] != $_SESSION['captcha'])
                    {
                        $errorsMsg[] = $config['placeholder']." est incorrect";
                    }
                }

                //vérification extensions autorisées + taille autorisée
                if($config['type'] == 'file')
                {
                    if(isset($paramsFiles))
                    {
                        $file = $paramsFiles[$name];
                        $filename = $file['name'];
                        $filenameTmp = $file['tmp_name'];
                        $extension = pathinfo($filename, PATHINFO_EXTENSION);
                        $size = $file['size'];

                        if($size > $config['maxBytes'] || $file['error'] === UPLOAD_ERR_INI_SIZE)
                        {
                            $errorsMsg[] = $config['placeholder']." est trop volumineux";
                        }

                        if(!in_array($extension, $config['extensions']))
                        {
                            $errorsMsg[] = $config['placeholder']." ne possède pas la bonne extension";
                        }
                    }
                    /*else
                    {
                        $errorsMsg[] = $config['placeholder']." est vide";
                    }*/
                }
            }

            //parcours des selects
            if(isset($form['select']))
            {
                foreach($form['select'] as $name => $config)
                {
                    //si multiple est spécifié dans la config
                    if(isset($config['multiple']))
                    {
                        //gestion des select simples
                        if(!$config['multiple'])
                        {
                            if((isset($config["required"]) && $config["required"]) && !self::minLength($paramsPost[$name], 1))
                            {
                                $errorsMsg[] = $config['placeholder']." est requis";
                            }
                        }
                        //gestion des select multiples
                        elseif($config['multiple'])
                        {
                            if((isset($config["required"]) && $config["required"]) && count($paramsPost[$name]) == 0)
                            {
                                $errorsMsg[] = $config['placeholder']." est requis";   
                            }
                        }
                    }
                    //si multiple n'est pas spécifié dans la config (donc ici que des select simples)
                    else
                    {
                        if((isset($config["required"]) && $config["required"]) && !self::minLength($paramsPost[$name], 1))
                        {
                            $errorsMsg[] = $config['placeholder']." est requis";
                        }
                    }
                }
            }

            return $errorsMsg;
        }

        public static function checkEmail($email)
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        public static function checkPwd($pwd)
        {
            return strlen($pwd) > 6 && strlen($pwd) < 12 && preg_match("/[A-Z]/", $pwd) && preg_match("/[a-z]/", $pwd) && preg_match("/[0-9]/", $pwd);
        }

        public static function minLength($value, $length)
        {
            return strlen(trim($value)) >= $length;
        }

        public static function maxLength($value, $length)
        {
            return strlen(trim($value)) <= $length;
        }
    }