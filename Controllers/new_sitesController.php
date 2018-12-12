
<?php 
    // if folder is in xampp htdocs
    if($_SERVER['SERVER_NAME']=='localhost'){
        $_SERVER['DOCUMENT_ROOT'] = __DIR__;
    }
?>

<?php require ('ControllerBase.php'); ?>

<?php

    class new_sitesController extends ControllerBase {
        private $siteObj;

        protected function defaultAction($params) { 
            $adminContent = Admin::getAdminContent("new_sites");          
            require ('Views/new_sitesView.php');
        }

        protected function loadSiteAction($params){
            $this->siteObj = new stdClass();
            try
            {
                if($params[0]){
                    $siteId = Helper::sanitize($params[0]);
                    $sitesModel = new DB('sites');
                    $siteValuesJson = $sitesModel->fetchWhere( $where =  " id = $siteId", $columnName =  "siteValues" );
                   

                    if(isset($siteValuesJson)){
                        $siteValuesJson = current($siteValuesJson);
                        $this->siteObj = json_decode($siteValuesJson['siteValues']);
                    }
    
                    require ('Views/new_sitesView.php');
                }else{
                    throw new Exception('Invocation error: the requested method '.$this->action.' requires site Id parameter. ');
                }
            }catch(Exception $e){
                echo __LINE__.$e->getMessage();
            }
        }

        public function populate($prop, $placeholder){
            if(isset($this->siteObj) && property_exists($this->siteObj, $prop)){
                return 'value="'.$this->siteObj->$prop.'"';
            }else{
                return 'placeholder="'.$placeholder.'"';
            }
        }
    }
?>

