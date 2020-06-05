<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $(".titreOrdo").hover(function(){
        $(this).css('cursor','pointer');
        $(this).css('backgroundColor','#CCC');
    });
    $(".titreOrdo").bind('mouseout',function(){
        $(this).css('backgroundColor','rgba(0,0,0,0)');
    });
    $(".titreOrdo").click(function(){
        var id=this.id;
        var idTarget="contenuOrdo"+id.replace("titreOrdo",'');
        
        if($("#"+idTarget).css('display')==='block'){
            $("#"+idTarget).css('display','none');
            $(this).css('backgroundColor','rgba(0,0,0,0)');
            $(".titreOrdo").bind('mouseout',function(){
                $(this).css('backgroundColor','rgba(0,0,0,0)');
            });
            
    
        }else{
            $(".contenuOrdo").css('display','none');
            
            $(".titreOrdo").css('backgroundColor','rgba(0,0,0,0)');
            $("#"+idTarget).css('display','block');
            $(this).css('backgroundColor','#CCC');
            $("#"+idTarget).css('backgroundColor','#eef2f6');
            
            $(".titreOrdo").unbind('mouseout');
        }
    });

</script>