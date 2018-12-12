<?php require ('ControllerBase.php'); ?>

<?php

    class view_TestController extends ControllerBase {
        private $siteObj;

        protected function defaultAction($params) {    
            require ('Views/test.php');
        }
    }
?>

