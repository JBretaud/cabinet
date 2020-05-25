<script>
// Creating a new Vue instance and pass in an options object.


var recherche = new Vue({

// A DOM element to mount our view model.

    el: '#recherche',

    // Define properties and give them initial values.

    data: {
        nom:'',
        prenom:'',
        requete:'',
        listePatients:'',
        listeTrie:'',
    },

    // Functions we will be using.
    methods: {
        setlistePatients:function(){
            var test=new Array()
            this.requete.forEach(function(Patient){
                test.push(Patient);
            });
            this.listePatients=test;
        },
    },
    computed:{
        filteredPatients: function () {
            var patients_array = this.listePatients,
                searchNom = this.nom;
                searchPrenom = this.prenom;

            if(!searchNom&&!searchPrenom){
                return {};
            }
            searchNom = searchNom.trim().toLowerCase();
            searchPrenom = searchPrenom.trim().toLowerCase();
            patients_array = patients_array.filter(function(item){
                if(item.nom.toLowerCase().indexOf(searchNom) !== -1){
                    if(item.prenom.toLowerCase().indexOf(searchPrenom) !== -1){
                        return item;
                    }
                }
            })
            return patients_array;;
        }
        
    },
    beforeMount(){
        this.requete=<?php 
            if(isset($ListePatients)){
                echo json_encode($ListePatients);
            }else{
                echo "''";
            }?>,
        this.setlistePatients();
    },
});

    
</script>