<?php 

Class Helper{

    //data sanitazing 
    function cleanInput($input) {
          $search = array(
            '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
          );
        
            $output = preg_replace($search, '', $input);
            return $output;
     }
 
    public static function sanitize($input) {
        if (is_array($input)) {
            foreach($input as $var=>$val) {
                $output[$var] = sanitize($val);
            }
        }else{
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $output  =  (new self)->cleanInput($input);
        }
        
        return $output;
    }

    public static function makeUrl($page, $action = "default", $params= []) {
    
       $url = $_SERVER['REQUEST_URI']."/".$page."/".$action;
        if(count($params)){
            foreach($params as $param){
                $url .= "/".$param;
            }
        }

        return $url;
    }
}

?>