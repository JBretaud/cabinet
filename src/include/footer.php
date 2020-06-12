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
        if($path[0]=="account"&&$path[1]==="new"){
            if(isset($path[2])){
                if($path[2]==="etape1"){
                    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'scriptVueEtape1.php';
                }
            }else{
                require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'scriptVueEtape1.php';
            }
        }elseif(isset($_SESSION['type']) && $path[0]=="secretaire"&&$_SESSION['type']===3||$path[0]==="praticien"&&$_SESSION['type']===2){
            if($path[1]=="recherche"&&$path[2]==="patient"){
                require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueRecherche.php';
            }elseif($path[1]==="fiche"){
                require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueChoixMed.php';
            }
        }
        if(isset($_SESSION) && $path[0]==='secretaire'&&$_SESSION['type']===3){
            if($path[1]==="rdv"){
                if($path[2]==="new"){
                    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueAfficheRdv.php';
                }
            }
        }
        if(isset($_SESSION) && $path[0]==='praticien'&&$_SESSION['type']===2){
            if($path[1]==="rdv"){
                if($path[2]==="new"){
                    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'VueAfficheRdv.php';
                }
            }
        }
        if(isset($_SESSION) && $path[0]==='patient'&&$_SESSION['type']===1){
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
        
        if($path[0]==='ordonnance'){
            if($path[1]==='form'){
                require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'OrdonnanceVue.php';
            }
        }
        
    }
    if(isset($_GET['alert'])||(isset ($path[1]) && $path[1]==="errorLogin")) require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'toasts.php';
    if((isset($_GET['patient'])&&!empty($_GET['patient']))&&(isset($_GET['praticien'])&&!empty($_GET['praticien']))){
        $gets='';
        foreach($_GET as $key=>$value){
            
            if(strpos($key, "Medicament") !== false && !empty($value['nom'])){
                $gets.="&{$key}[nom]={$value['nom']}&{$key}[posologie]={$value['posologie']}";
            }
        }
        $link = "
        <script> window.open('/cabinet/ordonnance/dl?patient=".$_GET['patient']."&praticien=".$_GET['praticien'].$gets."', 'width=710,height=555,left=160,top=170') </script>";
        echo "$link";
    }
    if(isset($path[1])&&($path[1]==="fiche"||$path[1]==="profil")) require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'toggleOrdonnance.php';
?>

    </body>
</html>