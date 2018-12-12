<?php

abstract class ControllerBase{
    private $action;
    private $params = [];

    function __construct (){
        if($_SESSION['action'] ){
            // avoiding reserved keywords as method names
            $this->action = $_SESSION['action'].'Action'; 
        }else{
            $this->action = 'defaultAction';
        }

        if($_SESSION['params'] ){
            $this->params = $_SESSION['params'];
        }

        $_SESSION['action'] = NULL;
        $_SESSION['params'] = NULL;
    }

    public function executeAction(){  
        try
		{
            if(method_exists($this, $this->action)){
                $methodName = $this->action;
                $this->$methodName($this->params);
            }else{
                throw new Exception('Invocation error: the requested method '.$this->action.' does not exist.');
            }
        }catch(Exception $e){
            echo __LINE__.$e->getMessage();
        }
    }

    abstract protected function defaultAction($params);
}

?>