
<script>
var Ordonnance = new Vue({

// A DOM element to mount our view model.

el: '#frameForm',

// Define properties and give them initial values.

data: {
    listeMed: {
        <?php for($i=0 ; $i<$nbMed ; $i++){
            if(isset($Meds[$i])&&isset($Posologie[$i])){
                $idMedicament="\"{$idMeds[$i]}\"";
                $nom="\"{$Meds[$i]}\"";
                $posologie="\"{$Posologie[$i]}\"";
            }else{
                $idMedicament="\"\"";
                $nom="\"\"";
                $posologie="\"\"";
            }
             echo "{$i}: {";
             echo "idMedicament: $idMedicament, ";
             echo "nom: $nom, ";
             echo "posologie: $posologie},";
         }?>
    },
    
},
beforeMount(){
        console.log(this.listeMed);
    },
methods:{
    setNom:function(){
        console.log(this.listeMed);
        console.log(this.listeMed[0]);
    }
},




});
</script>