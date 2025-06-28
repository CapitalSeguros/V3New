$(function(){

    showOptionsPerson();
});

function showOptionsPerson(){
    const urlKeys = new URLSearchParams(window.location.search);
    const onlyKeys = urlKeys.keys();
    const idP = $("#idPersona").val();
    const idTP = $("#tipoPersona option:selected").val();
    var count = 0;
    //console.log(typeof onlyKeys);

    for(var a of onlyKeys){

        switch(a){
            case "permitir" : 
                console.log("is internal");
                $(".agent-person").hide();
                $(".job-person").show();
            break;
            case "prospecto" : 
                console.log("is agent");
                $(".agent-person").show();
                $(".job-person").hide();
            break;
            case "liberar" :
                console.log("switch: set free");
                if(idTP == 3){
                    $(".agent-person").show();
                    $(".job-person").hide();
                } else{
                    console.log("switch: set free 2");
                    $(".agent-person").hide();
                    $(".job-person").show();
                }
            break;
            }

        count ++;
    }    

    if(count == 0){
        console.log(idP, idTP);
    
        if(idP > 0 && idTP == 3){
            console.log("load as agent");
            $(".agent-person").show();
            $(".job-person").hide();
        } else{
            console.log("load as employee");
            $(".agent-person").hide();
            $(".job-person").show();
        }
    }
}