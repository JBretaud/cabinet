<script>
    var AfficheRdv = new Vue({

// A DOM element to mount our view model.

el: '.dispRdv',

// Define properties and give them initial values.

data: {
    listeRdv:'',
    requete:'',
},

// Functions we will be using.

methods: {
    hydrateListeRdv:function(){
        var test=new Array()
            for(j=0;j<this.requete.length;j++){
                if (j>=<?=$iDeb?>){
                    console.log(this.requete[j]);
                    this.requete[j].replace(' ','T');
                    test.push(new Date(this.requete[j]));
                }
                if (j><?=$iDeb?>+1)break;
            }
            <?php unset($iDeb);?>
            this.listeRdv=test;
    }
},
beforeMount(){
        this.requete=<?php 
                        if(isset($listeCreneaux)){
                            echo json_encode($listeCreneaux);
                        }else{
                            echo "''";
                        }?>,
        this.hydrateListeRdv();
    },
});
</script>