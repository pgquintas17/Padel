<?php

    class ValidationException extends Exception {
        
        private $errores = array();

        public function __construct(array $errores, $msg = NULL) {
            parent::__construct($msg);
            $this->errores = $errores;
        }

        public function getErrores() {
            return $this->errores;
        }
    }

?>