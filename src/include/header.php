<?php 
session_start();
include_once ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
if(!empty($_GET['path'])){
    $path=explode("/",$_GET['path']);

    if (($path[0]!="ordonnance"&&$path[0]!="praticien")&&(!isset($path[1])||$path[1]!="ordonnance")){
        if(isset($_SESSION['idOrdonnance'])) {
            unset($_SESSION['idOrdonnance']);
        }
    }
}
?>

<?php if($path[0]!="ordonnance" || ($path[0]==="ordonnance" && $path[1]=="form")):?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="/cabinet/public/css/calendar.css">
        <link rel="stylesheet" href="/cabinet/public/css/rdv.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.5/vue.min.js"></script>
    </head>
<?php endif;
if($path[0]!="ordonnance"):?>
    <body> 
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <?php if (!isset($path[1])||(isset($path[1])&&$path[1]!="ordonnance")):?>
        <nav id="navbar" class="menu navbar navbar-dark bg-primary mb-3">
            
            <div>
            <a href="/cabinet/accueil" class="navbar-item home">&#8962;</a>
        <?php if(isset($_SESSION['login'])):?>

            <a <?php if($_SESSION['type']===1){echo "href='/cabinet/patient/profil'";}else{echo "href='#'";} ?> id="loggedName" class ="navbar-brand"><?=strtoupper($_SESSION['login'])?></a>

            <?php if($_SESSION['type'] === 3||$_SESSION['type']===2): ?>
                <a href='<?=($_SESSION['type']===3) ? "/cabinet/secretaire/recherche/patient" : "/cabinet/praticien/recherche/patient"?>' class ="navbar-item">RECHERCHE PATIENT</a>
            <?php endif; ?>
            <?php if($_SESSION['type'] === 4):?>
                <a href="/cabinet/admin/accounts/display" class ="navbar-item">Comptes</a>
            <?php endif; ?>
            <?php if($_SESSION['type']===1): 
                require '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'loggedToObjects.php';
                ?>
                <a href='/cabinet/patient/rdv/new?idPatient=<?=$idPatient?>' class ="navbar-item">PRENDRE RDV</a>
            <?php endif; ?>
            <?php if($_SESSION['type']!==4): ?>
            <a href="/cabinet/calendar/month" class ="navbar-item"><?= (isset($_SESSION['type']) && $_SESSION['type'] === 1) ? "MON CALENDRIER" : ($_SESSION['type'] === 2) ?  "MON AGENDA" :  "CALENDRIER" ;?></a>
            <?php endif; ?>
        <?php endif; ?>
        
            </div>
        <?php if(isset($_SESSION['login'])):?>
            
            <a href="/cabinet/logout" class ="navbar-item">LOGOUT</a>
        <?php else: 
            if(!empty($path[0])):
                if($path[0]!="account"): ?>
            <a @click="toggleAuth" id="idButton" class ="navbar-item">S'IDENTIFIER</a>
        <?php   endif;
            else:?>
                
             <a @click="toggleAuth" id="idButton" class ="navbar-item">S'IDENTIFIER</a>

             <?php endif;
        endif;?>
            <button  id="boutonMenu" class="navbar-toggler" type="button" style="display:none">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div v-if="show_auth" v-cloak id="authentification" >
            <form class="d-inline-flex flex-column align-items-stretch" method="POST" action="/cabinet/login">
                <input class="mt-5 m-2 p-2 form-control" type="text" name="login" required placeholder="Identifiant">
                <input class="mb-4 m-2 p-2 form-control" type="password" name="pass" required placeholder="Mot de Passe">
                <div class="d-flex flex-row justify-content-between mb-2 p-2">
                    <a href="/cabinet/account/new" class="btn btn-secondary" @click="hideAuth">CREER UN COMPTE</a>
                    <button type="submit" class="btn btn-primary">LOG IN</button>
                </div>
            </form>
        </div>
        <div id="overlapAuth" v-cloak v-if="show_auth" @click="hideAuth">

        </div>
        
        </nav>
        
        <?php
        endif;
            if(isset ($path[1]) && $path[1]==="errorLogin"):
        ?>
        <div class="d-flex flex-row justify-content-center w-100 pop-up">
            <div class="toast alert alert-danger w-50"  data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                ERREUR: Identifiant ou mot de passe non reconnus.
            </div>
        </div>

        <?php elseif(isset($_GET['alert'])):
            if($_GET['alert']==="deleteRdv"):?>
            <div class="d-flex flex-row justify-content-center w-100 pop-up">
                <div class="toast alert alert-success" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                    Le rendez-vous a bien été annulé.
                </div>
            </div>
            <?php elseif($_GET['alert']==="updateRdv"):?>
                
                <div class="d-flex flex-row justify-content-center w-100 pop-up">
                    <div class="toast alert alert-success" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                            Le rendez-vous a bien été mis à jour.
                    </div>
                </div>
            <?php elseif($_GET['alert']==="deleteRdvFail"):?>
                <div class="d-flex flex-row justify-content-center w-100 pop-up">
                    <div class="toast alert alert-danger" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                        Une erreur est survenue lors de la suppression du rendez-vous. Veuillez réessayer.
                    </div>
                </div>
            <?php elseif($_GET['alert']==="CompteCree"):?>
                <div class="d-flex flex-row justify-content-center w-100  pop-up">
                    <div class="toast alert alert-success h-auto" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                        Votre compte a été créé.
                    </div>
                </div>
            <?php elseif($_GET['alert']==="CompteCreaError"):?>
                <div class="d-flex flex-row justify-content-center w-100  pop-up">
                    <div class="toast alert alert-danger h-auto" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                        Une erreur est survenue lors de la création du compte.
                    </div>
                </div>
            <?php elseif($_GET['alert']==="deconnexion"):?>
                <div class="d-flex flex-row justify-content-center w-100  pop-up">
                    <div class="toast alert alert-danger h-auto" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                        Vous avez été déconnecté.
                    </div>
                </div>
            <?php elseif($_GET['alert']==="accountUpdated"):?>
                <div class="d-flex flex-row justify-content-center w-100  pop-up">
                    <div class="toast alert alert-success h-auto" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                        Information de compte mis à jours.
                    </div>
                </div>
            <?php elseif($_GET['alert']==="OrdonnanceCancel"):?>
                <div class="d-flex flex-row justify-content-center w-100  pop-up">
                    <div class="toast alert alert-danger h-auto" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                        Création d'ordonnance annulée.
                    </div>
                </div>
            <?php elseif($_GET['alert']==="RdvPris"):?>
                <div class="d-flex flex-row justify-content-center w-100  pop-up">
                    <div class="toast alert alert-danger h-auto" data-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                        Le rendez-vous demandé n'est pas disponible.
                    </div>
                </div>
                <?php endif;?>
            <?php endif;?>
        <?php endif;?>
        
        