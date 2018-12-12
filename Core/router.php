<?php


class Route
{

    private $currentUrl = "";

    function __construct() {

        $this->currentUrl = $_SERVER['REQUEST_URI']; 
    }
    
    //returns an array of param an args
    public function manage_routing(){
        $result =  $this->constructUrl($this->get_url_params($this->get_url()));
        $filename = '/path/to/foo.txt';
        $filename = $result['path'];

        try{
            if (!file_exists($filename)) {
                throw new Exception("The controller $filename does not exist");
            }
        }

        catch(Exception $e) {
            echo  $e->getMessage();
        }
        if (!file_exists($filename)) {
            throw new Exception("Invocation error: The controller $filename does not exist");
        }
        
        return $result;
    }

    private function constructUrl($paramsArr){
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(isset($paramsArr['action'])){
            $_SESSION['action'] = $paramsArr['action'];
        }

        if(isset($paramsArr['params'])){
           $_SESSION['params'] = $paramsArr['params'];
        }

        $redirectionArray = [];
        $redirectionArray['path'] = "Controllers/".$paramsArr['page']."Controller.php";
        $redirectionArray['classname'] = $paramsArr['page']."Controller";
        return $redirectionArray;
       
    }

    private function get_url(){
        $trimed = $this->currentUrl;
        if (strpos($a, '\?') !== false) {
            $trimed = trim(split('\?',$this->currentUrl )[0],'/');
        }
        $urlArr = array_values(array_filter(explode('/',$trimed)));	
		return $urlArr;
    }

    //expected url format is controller/action/param1/paramN
    private function get_url_params($urlArr){


        //just for local env text purposes remove this folder name
        if (($key = array_search('lpg', $urlArr)) !== false) {
            unset($urlArr[$key]);
        }

        $urlArray = [];
        $paramsArray = [];
        $pagePosition = 1;
        $actionPosition = 2;
        $paramsPosition = 3;
        if(count($urlArr)){
            for($counter = 1; $counter <= count($urlArr); $counter++ ){
                    if($counter == $pagePosition){
                        if(strlen($urlArr[$counter])){
                            $urlArray['page'] = $urlArr[$counter];
                        }else{
                            throw new Exception('Controller name is a mandatory field');
                        }
                        
                    }
                    if($counter == $actionPosition){
                        if(strlen($urlArr[$counter]) > 0){
                            $urlArray['action'] = $urlArr[$counter];
                        }else{
                            $urlArray['action'] = "default";
                        }
                       
                    }
                    if($counter >= $paramsPosition){
                        $currentParam = Helper::sanitize($urlArr[$counter]) ;
                        array_push($paramsArray, $currentParam ) ;
                    }
            }
            if(!isset( $urlArray['action'])){ $urlArray['action'] = "default";}
            $urlArray['params'] = $paramsArray ;
        }else{
            $urlArray['page'] = 'sites';
            $urlArray['action'] = 'default';
        }
        return $urlArray;
    }
}