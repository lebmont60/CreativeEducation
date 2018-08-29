<?php
    class ErrorController
    {
        public function _403Action($params)
        {
            //récupération du code d'erreur : suppression '_' puis 'Action'
            $code = str_replace('_', '', __FUNCTION__);
            $code = str_replace('Action', '', $code);

            $v = new View("error-display", "errors");
            $v->assign("code", $code);
            $v->assign("message", "Accès interdit");
        }

        public function _404Action($params)
        {
            //récupération du code d'erreur : suppression '_' puis 'Action'
            $code = str_replace('_', '', __FUNCTION__);
            $code = str_replace('Action', '', $code);

            $v = new View("error-display", "errors");
            $v->assign("code", $code);
            $v->assign("message", "Page introuvable");
        }

        public function _500Action($params)
        {
            //récupération du code d'erreur : suppression '_' puis 'Action'
            $code = str_replace('_', '', __FUNCTION__);
            $code = str_replace('Action', '', $code);

            $v = new View("error-display", "errors");
            $v->assign("code", $code);
            $v->assign("message", "Erreur interne");
        }

        public function _503Action($params)
        {
            //récupération du code d'erreur : suppression '_' puis 'Action'
            $code = str_replace('_', '', __FUNCTION__);
            $code = str_replace('Action', '', $code);

            $v = new View("error-display", "errors");
            $v->assign("code", $code);
            $v->assign("message", "Service indisponible");
        }

        public function _504Action($params)
        {
            //récupération du code d'erreur : suppression '_' puis 'Action'
            $code = str_replace('_', '', __FUNCTION__);
            $code = str_replace('Action', '', $code);

            $v = new View("error-display", "errors");
            $v->assign("code", $code);
            $v->assign("message", "Délai d'attente écoulé");
        }
    }