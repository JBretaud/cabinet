<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $(".titreOrdo").hover(function(){
        $(this).css('cursor','pointer');
    });
    $(".titreOrdo").click(function(){
        var id=this.id;
        var idTarget="contenuOrdo"+id.replace("titreOrdo",'');
        
        

        
        if($("#"+idTarget).css('display')==='block'){
            $("#"+idTarget).css('display','none');
            $(this).css('backgroundColor','rgba(0,0,0,0)');
            $(this).css('color','rgb(77, 77, 77)');
        }else{
            $(".contenuOrdo").css('display','none');
            $(".titreOrdo").css('color','rgb(77, 77, 77)');
            $(".titreOrdo").css('backgroundColor','rgba(0,0,0,0)');
            $("#"+idTarget).css('display','block');
            $(this).css('backgroundColor','rgb(99,99,99)');
            $("#"+idTarget).css('backgroundColor','#eef2f6');
            $(this).css('color','rgb(226, 226, 226)');
        }
    });

</script>