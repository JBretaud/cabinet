
<script>
var Ordonnance = new Vue({

// A DOM element to mount our view model.

el: '#frameForm',

// Define properties and give them initial values.

data: {
    listeMed: {
        <?php for($i=0 ; $i<$nbMed ; $i++){
            if(isset($Meds[$i])&&isset($Pos[$i])){
                $nom="\"{$Meds[$i]}\"";
                $pos="\"{$Pos[$i]}\"";
            }else{
                $nom="\"\"";
                $pos="\"\"";
            }
             echo "{$i}: {";
             echo "nom: $nom,";
             echo "pos: $pos},";
         }?>
    },
    
},


});
</script>