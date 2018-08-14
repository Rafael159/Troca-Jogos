$(document).ready(function(){
    
    function setConsoles(){

        $.post("carrega-consoles.php", function(data){

            $('select[name=console]').html(data);

        });

    }

    setConsoles();
});