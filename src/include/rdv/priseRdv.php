<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Date'.DIRECTORY_SEPARATOR.'Day.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    if($_SESSION['type']==1){
        $typeUser="patient";
    }elseif($_SESSION['type']==2){
        $typeUser="praticien";
    }elseif($_SESSION['type']==3){
        $typeUser="admin";
    }
    
    try {
        $day = new Day($_GET['year'] ?? null,$_GET['month'] ?? null, $_GET['day'] ?? null);
    } catch (\Exception $e){
        $day = new Day();
    }
    if(isset($_POST['idPraticien'])){
        $idPraticien=$_POST['idPraticien'];
    }elseif(isset($_GET['idPraticien'])&&$_GET['idPraticien']!="---"){
        $idPraticien=$_GET['idPraticien'];
    }elseif($_SESSION['type']===1||$_SESSION['type']===3){
        
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'patientDAO.php';
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
        
        $patientDAO=new patientDAO($pdo);
        $patient=$patientDAO->get($_GET['idPatient']);
        $idPraticien=$patient->getIdPraticien();
        
        
    }
    $praticienDAO=new praticienDAO($pdo);
    $ListePraticiens=$praticienDAO->getListe();
    $ListeIdPraticiens=[];
    
    if ($_SESSION['type']==3){
        $adress="'/cabinet/admin/rdv/book?idPatient=";
    }elseif($_SESSION['type']==1){
        $adress="'/cabinet/patient/rdv/book?idPatient=";
    }

    $rdvDAO=new rdvDAO($pdo);
    
        if (!$day->pastDay()&&isset($idPraticien)){
            $listeRdvReserves=$rdvDAO->getAllDayRdv($day,$idPraticien);
            $listeCreneauxReserves=[];
            foreach($listeRdvReserves as $creneau){
                $debut=new DateTime($creneau->getStart());
                array_push($listeCreneauxReserves,[
                    'debut'=>$debut,
                    'fin'=>(clone $debut)->modify("+{$creneau->getDuree()} minutes")
                ]);
            }
            
            $start=$day->getStart();
            $creneau=$start;
            $listeCreneaux=[];
            $i=0;
            $iDeb=0;
            $borneMoins=null;
            while($creneau->format('H')<19){
                
                
                foreach($listeCreneauxReserves as $creneauReserve){
                    if ((clone $creneau)->modify("+20 minutes")>=$creneauReserve['debut'] && (clone $creneau)->modify("+20 minutes")<=$creneauReserve['fin']){
                        $creneau=$creneauReserve['fin'];
                    }
                }
                $end = [
                    'H'=>(clone $creneau)->modify("+20 minutes")->format('H'),
                    'i'=>(clone $creneau)->modify("+20 minutes")->format('i'),
                ];
                
                if(($creneau->format('H')<12||$creneau->format('H')>=13)&&($end<=12||($end>=13&&($end['H']<19||($end['H']===19)&&$end['i']===0)))){
                    if(!$day->pastHour((clone $creneau))){
                        
                        array_push($listeCreneaux,(clone $creneau)->format('Y-m-d H:i'));
                        $i++;
                        
                    }
                    if ($i>2 && isset($_GET['debut'])&&$creneau->format('H:i')==$_GET['debut']){
                        if(isset($listeCreneaux[$i-4])){
                            $dateSplit=explode(" ",$listeCreneaux[$i-4]);
                        }elseif(isset($listeCreneaux[$i-3])){
                            $dateSplit=explode(" ",$listeCreneaux[$i-3]);
                        }elseif(isset($listeCreneaux[$i-2])){
                            $dateSplit=explode(" ",$listeCreneaux[$i-2]);
                        }
                        $borneMoins=$dateSplit[1];
                        $iDeb=$i-1;
                    }
                }
                
                $creneau->modify("+20 minutes");

            }
            
         
            
        }
    
?>
<div  class="w-100 d-flex flex-column align-items-center">
    <form class="my-4 d-flex flex-column justify-content-center align-items-center col-xl-3 col-lg-4 col-md-6 col-sm-8"  action="#" method="post">
            <label class="my-2" for="idPraticien"><h2>Praticien :</h2></label>
            <select class="form-control" onchange="this.form.submit()" name="idPraticien">
                <option value="---">---</option>
                <?php foreach($ListePraticiens as $Praticien): ?>
                <option value="<?= $Praticien->getIdPraticien() ?>" <?php 
                    if(isset($_POST['idPraticien'])||isset($_GET['idPraticien'])){
                        if(isset($_POST['idPraticien'])&&$_POST['idPraticien']!=null){
                            if($Praticien->getIdPraticien()==$_POST['idPraticien']){
                                echo "selected ";
                            }
                        }else{
                            if(isset($_GET['idPraticien']) && $Praticien->getIdPraticien()==$_GET['idPraticien']){
                                echo "selected";
                            }elseif($idPraticien==$Praticien->getIdPraticien()){
                                echo "selected";
                            }
                        }
                    }?>
                ><?="Dr. ".$Praticien->getPrenom().' '.$Praticien->getNom()?></option>
                <?php endforeach;?>
            </select>
    </form>
    <div class="mt-5 d-flex flex-row align-items-center justify-content-between col-xl-6 col-lg-7 col-md-10 col-sm-12">
        <a href="/cabinet/<?=$typeUser?>/rdv/new?<?php if(isset($idPraticien)) echo "idPraticien=".$idPraticien."&" ?>idPatient=<?=$_GET['idPatient']?>&month=<?= $day->previousDay()->getMonth()?>&year=<?= $day->previousDay()->getYear(); ?>&day=<?= $day->previousDay()->getDay(); ?>" class="btn btn-primary GreenSideArrows"><img src="/cabinet/src/img/left vert.png"></a>
        <h1><?=$day->toString()?></h1>
        <a href="/cabinet/<?=$typeUser?>/rdv/new?<?php if(isset($idPraticien)) echo "idPraticien=".$idPraticien."&" ?>idPatient=<?=$_GET['idPatient']?>&month=<?= $day->nextDay()->getMonth()?>&year=<?= $day->nextDay()->getYear(); ?>&day=<?= $day->nextDay()->getDay(); ?>" class="btn btn-primary GreenSideArrows"><img src="/cabinet/src/img/right vert.png"></a>
    </div>
    
    <?php if(isset($idPraticien)): ?>
    <ul class="dispRdv d-flex flex-row justify-content-center align-items-center flex-nowrap col-xl-6 col-lg-8 col-md-10 col-sm-11">
        <div class="m-4" style="width:10%">
        <?php if (!empty ($borneMoins)): ?>
            <a  href="/cabinet/<?=$typeUser?>/rdv/new?<?php if(isset($idPraticien)) echo "idPraticien=".$idPraticien."&" ?>idPatient=<?=$_GET['idPatient']?>&month=<?= $day->getMonth()?>&year=<?= $day->getYear(); ?>&day=<?= $day->getDay(); ?>&debut=<?=$borneMoins?>" class="BlueSideArrows justify-content-center d-flex flex-row align-items-center btn btn-primary"><img src="/cabinet/src/img/left bleu.png"></a>
        <?php endif;?>
        </div>
        
        <li class="my-3 mx-2 text-center" style="max-width:24%" v-for="creneau in listeRdv">
            <?php if (!$day->pastDay()): ?>
            
            <a v-bind:href="<?= $adress.$_GET['idPatient'] ?>&creneau='+(creneau.getYear()+1900)+'-'+(creneau.getMonth()+1)+'-'+creneau.getDate()+'-'+creneau.getHours()+'-'+creneau.getMinutes()+'&idPraticien=<?=$idPraticien?>'" class="d-flex flex-column align-items-center justify-content-around">
                <span class="heure" v-if="creneau.getMinutes()>=10"><b>- {{creneau.getHours()}}:{{creneau.getUTCMinutes()}} -</b></span>
                <span class="heure" v-if="creneau.getMinutes()<10"><b>- {{creneau.getHours()}}:0{{creneau.getUTCMinutes()}} -</b></span>
                <span> Prendre <br> Rendez-vous  </span>
            </a>
            <?php else: ?>
            <div class="m-0 alert alert-danger">
                Pas de créneaux disponibles ce jour.
            </div>
            <?php endif; ?>
        </li>
        <div class="m-4" style="width:10%">
        
        <?php if(isset($iDeb)&&isset($listeCreneaux[$iDeb+3])):
            $dateSplit=explode(" ",$listeCreneaux[$iDeb+3]);
            $bornePlus=$dateSplit[1];
            
            ?>
            <a href="/cabinet/<?=$typeUser?>/rdv/new?<?php if(isset($idPraticien)) echo "idPraticien=".$idPraticien."&" ?>idPatient=<?=$_GET['idPatient']?>&month=<?= $day->getMonth()?>&year=<?= $day->getYear(); ?>&day=<?= $day->getDay();?>&debut=<?=$bornePlus?>" class="BlueSideArrows d-flex flex-row align-items-center justify-content-center btn btn-primary"><img src="/cabinet/src/img/right bleu.png"></a>
        <?php endif; ?>
        </div>
    </ul>
</div>
<?php endif; ?>