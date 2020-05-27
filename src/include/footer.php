<script>
    var demo = new Vue({

// A DOM element to mount our view model.

el: '.navbar',

// Define properties and give them initial values.

data: {
    show_auth: false,
},

// Functions we will be using.

methods: {
    hideAuth: function(){
        // When a model is changed, the view will be automatically updated.
        this.show_auth = false;
    },
    // Change la valeur de l'attribut "show_tooltip" de l'objet vue demo.
    toggleAuth: function(){
        this.show_auth = !this.show_auth;
    }
}
});
</script>
<?php
    if (isset($path)){
        if($path[0]=="account"&&$path[1]=="new"){
            if(isset($path[2])){
                if($path[2]=="etape1"){
                    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'scriptVueEtape1.php';
                }
            }else{
                require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'scriptVueEtape1.php';
            }
        }elseif($path[0]=="admin"){
            if($path[1]=="recherche"&&$path[2]=="patient"){
                require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueRecherche.php';
            }elseif($path[1]=="fiche"){
                require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueChoixMed.php';
            }
        }
        if($path[0]=='admin'&&$_SESSION['type']=3){
            if($path[1]=="rdv"){
                if($path[2]=="new"){
                    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueAfficheRdv.php';
                }
            }
        }
        if($path[0]==='patient'&&$_SESSION['type']=1){
            if($path[1]==="rdv"){
                if($path[2]==="new"){
                    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueAfficheRdv.php';
                }
            }elseif($path[1]==="profil"){
                if (!isset($path[2])){
                    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueChoixMed.php';
                }
            }
        }
    }
    if(isset($_GET['alert'])||(isset ($path[1]) && $path[1]==="errorLogin")) require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'toasts.php';
?>
    </body>
</html>