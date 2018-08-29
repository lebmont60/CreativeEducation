<?php
    class Auth
    {
        public static function loginForm()
        {
            return [
                "config" => [
                    "method" => "POST",
                    "action" => "index/login"
                ],
                "input" => [
                    "email" => [
                        "type" => "email",
                        "placeholder" => "Adresse mail",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "icon" => "drafts"
                    ],
                    "password" => [
                        "type" => "password",
                        "placeholder" => "Mot de passe",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "icon" => "lock_outline"
                    ]
                ],
                "button" => [
                    "text" => "CONNEXION",
                    "icon" => "keyboard_arrow_right"
                ],
                "captcha" => false,
                "forgotPassword" => true
            ];
        }

        public static function registerForm()
        {
            return [
                "config" => [
                    "method" => "POST",
                    "action" => "index/register"
                ],
                "input" => [
                    "firstname" => [
                        "type" => "text",
                        "placeholder" => "Prénom",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "icon" => "account_circle"
                    ],
                    "lastname" => [
                        "type" => "text",
                        "placeholder" => "Nom",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "icon" => "account_circle"
                    ],
                    "email" => [
                        "type" => "email",
                        "placeholder" => "Adresse mail",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "icon" => "drafts"
                    ],
                    "password" => [
                        "type" => "password",
                        "placeholder" => "Mot de passe",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "icon" => "lock_outline"
                    ],
                    "passwordConfirm" => [
                        "type" => "password",
                        "placeholder" => "Confirmation mot de passe",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "confirm" => "password",
                        "icon" => "check_circle_outline"
                    ],
                    "captcha" => [
                        "type" => "text",
                        "placeholder" => "Code de sécurité",
                        "required" => true,
                        "icon" => "spellcheck"
                    ]
                ],
                "button" => [
                    "text" => "INSCRIPTION",
                    "icon" => "keyboard_arrow_right"
                ],
                "captcha" => true
            ];
        }

        public static function forgottenPasswordForm()
        {
            return [
                "config" => [
                    "method" => "POST",
                    "action" => "index/forgottenPassword"
                ],
                "input" => [
                    "email" => [
                        "type" => "email",
                        "placeholder" => "Adresse mail",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "icon" => "drafts"
                    ]
                ],
                "button" => [
                    "text" => "ENVOYER",
                    "icon" => "keyboard_arrow_right"
                ],
                "captcha" => false,
                "forgotPassword" => false
            ];
        }

        public static function renewPasswordForm()
        {
            return [
                "config" => [
                    "method" => "POST",
                    "action" => ""
                ],
                "input" => [
                    "password" => [
                        "type" => "password",
                        "placeholder" => "Mot de passe",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "icon" => "lock_outline"
                    ],
                    "passwordConfirm" => [
                        "type" => "password",
                        "placeholder" => "Confirmation mot de passe",
                        "required" => true,
                        "minString" => 2,
                        "maxString" => 100,
                        "confirm" => "password",
                        "icon" => "check_circle_outline"
                    ]
                ],
                "button" => [
                    "text" => "ENREGISTRER",
                    "icon" => "keyboard_arrow_right"
                ],
                "captcha" => false,
                "forgotPassword" => false
            ];
        }
    }