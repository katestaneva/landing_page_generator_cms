// A $( document ).ready() block.
$( document ).ready(function() {
    
    //event handelrs
    $(".toggle-elemenets").on( "click", function(e) {
        e.preventDefault();
        var parent_container =  $( this ).attr('parent-container');
        var child_element_class = $("#"+parent_container+" .select-elements").val() ;
      
        if(child_element_class != 0 ){
            $("#"+parent_container+" ."+child_element_class).show('slow');
        }
    });

    $(".hide-element").on( "click", function(e) {
        e.preventDefault();
        var parent_container =  $( this ).attr('parent-container');
        var child_element_class = $( this ).attr('child-element-class');
        
        $("#"+parent_container+" ."+child_element_class).hide('slow');
        
    });

    $(".file-input").on( "change", function(e) {
        var files = $( this ).prop("files");
        var names = $.map(files, function(val) { return val.name; });
        alert(names[0]);
        if(!names[0] || names[0] == undefined || names[0] == "" || names[0].length == 0){
            $( this ).closest( ".input-holder .img-container" ).show();
            $( this ).closest( ".input-holder .img-container img" ).attr("src",names[0]);
            $( this ).closest( ".input-holder .img-container img" ).attr("src",names[0]);
        }
    });

    
    
});