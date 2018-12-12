<?php 
    // if folder is in xampp htdocs
    if($_SERVER['SERVER_NAME']=='localhost'){
        $_SERVER['DOCUMENT_ROOT'] = __DIR__;
    }
?>

<?php require ('ControllerBase.php'); ?>

<?php
    class sitesController extends ControllerBase {

        protected function defaultAction($params) { 
            $sitesModel = new DB('sites');
            $this->sortGrid($params);
            print_r($_SESSION);
            echo(" order direction ".$orderDirection);
            echo(" order by ".$orderBy);
            die("HERE1");
            require ('Views/sitesView.php');
        }

        private function sortGrid($params){
       
            $limiter = "";
            $orderBy = "";
            $orderDirection = "";
            $orderBy = ( isset($params[0]) ) ? Helper::sanitize($params[0]) : 'id';

            // default order asc, order by id
            if(!isset($_SESSION['order'])){$_SESSION['order'] = 'asc';}
            if(!isset($_SESSION['oldorderBy'])){$_SESSION['oldorderBy'] = $orderBy;}

            //reorder grid
            if(isset($_SESSION['order']) && $_SESSION['oldorderBy']==$orderBy ){
            ($_SESSION['order'] == 'asc' ) ? $_SESSION['order'] = 'desc' :  $_SESSION['order'] = 'asc'; 
            }else{
                $_SESSION['order'] = 'asc' ;
            }
            $_SESSION['oldorderBy'] = $orderBy;
            $orderDirection = $_SESSION['order'] ;
        }
    }
?>

