<?php

    class SessionMessage {

        public static function setErrores($errs) {
            $_SESSION["errs"] = $errs;
        }

        public static function addError($err) {
            $_SESSION["errs"][] = $err;
        }

        public static function getErrores() {
            if(isset($_SESSION["errs"])) {
                $errs = $_SESSION["errs"];
                unset($_SESSION["errs"]);
                return $errs;
            } else {
                return null;
            }
        }

        public static function setMessage($msg) {
            $_SESSION["msg"] = $msg;
        }

        public static function getMessage() {
            if(isset($_SESSION["msg"])) {
                $msg = $_SESSION["msg"];
                unset($_SESSION["msg"]);
                return $msg;
            } else {
                return null;
            }
        }
    }

?>