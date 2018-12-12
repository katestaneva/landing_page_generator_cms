<?php 

Class Admin{

    public static function getAdminContent($adminPage) {
        if($adminPage){
            $adminElementsModel = new DB('admin_elements');
            $adminValuesJson = $adminElementsModel->fetchWhere( $where =  " page = '$adminPage' ", NULL, ["element", "value_json"],  $orderBy =  "id");
            return Admin::parseJson($adminValuesJson);;
        }
    }

    public static function  parseJson($jsonObject){
        $htmlOutput = '<div>
        <form class="form-horizontal" method="post" id="theForm" enctype="multipart/form-data">';
        $containersCounter = 0;
        foreach($jsonObject as $index => $section) {
            $containersCounter ++;
            $htmlOutput .= 
            '<div class="panel panel-default" id="'.$section['element'].'-id">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$containersCounter .'">'.$section['element'].'</a>
                    </h4>
                </div>
                <div id="collapse'.$containersCounter .'" class="panel-collapse collapse">
                    <div class="panel-body">';
                        $currentElementsId = [];
                        $html = "";
                        if(isset($section['value_json'])){
                            $decodedObj = json_decode($section['value_json']);
                        }

                        foreach($decodedObj as $element => $content) {
                            $element_header = ucwords(str_replace("_"," ",$element));
                            $currentElementsId[$element."-class"] = $element_header;

                            $html .= "
                            <fieldset class='jumbotron collapse ".$element."-class"."'>
                                <button class='hide-element' parent-container='".$section['element']."-id'  child-element-class='".$element."-class'> X </button>
                                <legend>".$currentElementsId[$element."-class"]."</legend>";
                                    $currentInput = "";
                                    foreach($content as $inputFieldName => $inputFieldVal) {
                                        
                                        $currentInput = "";
                                        $name = $element.'-'.$inputFieldName.'-name';
                                        $placeholder = $inputFieldVal->placeholder;
                                        $attribute = $inputFieldVal->attribute;
                                        
                                        if($inputFieldVal->type == "text" ){
                                            $currentInput .= 
                                            '<div class="input-holder" >
                                                <label>'.$inputFieldVal->label.'</label>
                                                <input type="text" attribute_type="'.$attribute.'" class="text-input" name="'.$name.'"/>
                                            </div>';
                                        }elseif($inputFieldVal->type == "file" ){
                                            $currentInput .= 
                                            '<div class="input-holder" >
                                                <label class="col-md-2">'.$inputFieldVal->label.'</label>
                                                <input type="file" attribute_type="'.$attribute.'" class="file-input col-md-8" name="'.$name.'"/>
                                                <p class="img-container">
                                                    <button class="btn btn-danger btn-lg remove-img" class="col-md-2">X</button>
                                                    <img src=""/>
                                                </p>
                                            </div>';
                                        }elseif($inputFieldVal->type == "dropdown" ){
                                            $currentInput .= 
                                            '<div class="input-holder" >
                                                <label>'.$inputFieldVal->label.'</label>
                                                <select class="dropdown-input" attribute_type="'.$attribute.'"  name="'.$name.'"> ';
                                                foreach($inputFieldVal->values as $key => $value) {
                                                    $currentInput .= '<option value="'.$value.'">'.$key.'</option>';
                                                }
                                            $currentInput .= '
                                                </select>
                                            </div>';
                                        }

                                        $html .= $currentInput."\n";
                                    }
                            $html .= '<button id="'.$section['element'].'-preview-id" > Update </button>
                            </fieldset>';
                        }
                        $adminHeaderSection  = '
                        <select class="select-elements">
                            <option value="0">What whould you like to display in the '.$section["element"].'</option>';
                        foreach ($currentElementsId as $value => $id){
                            $adminHeaderSection  .= "<option value='".$value."'>".$id."</option>";
                        }
                        $adminHeaderSection  .= "</select>";
                        $adminHeaderSection  .= '<button class="toggle-elemenets" parent-container="'.$section['element'].'-id"> Add </button>';

                        $htmlOutput .= $adminHeaderSection;
                        $htmlOutput .= $html;
                        $htmlOutput .= ' 
                    </div>
                </div>
            </div>';
        }
        $htmlOutput .= '</form>';
        $htmlOutput .= '</div>';

        return $htmlOutput;
    }
}

?>