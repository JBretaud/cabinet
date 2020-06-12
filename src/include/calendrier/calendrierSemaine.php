<?php
    
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Date'.DIRECTORY_SEPARATOR.'Week.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'LoggedToObjects.php';
    $praticienDAO=new praticienDAO($pdo);
    $patientDAO=new patientDAO($pdo);
    $rdvDAO=new rdvDAO($pdo);
    $ListePraticiens=$praticienDAO->getListe();
            try {
                $week = new App\Date\Week($_GET['month'] ?? null, $_GET['year'] ?? null, $_GET['week'] ?? null);
            } catch (\Exception $e){
                $week = new App\Date\Week();
            }
            
             $start=$week->getStartingDay();
             $end=(clone $start)->modify("+6 days +20 hours");
             $listeRDV=null;
            if(isset($_GET['idPraticien'])&&$_GET['idPraticien']!="---"){
                $personne=$praticienDAO->get($_GET['idPraticien']);
            }
            if(isset($personne)){
                $listeRDV=$rdvDAO->getSpan($start,$end,$personne);
            }
            // var_dump($listeRDV);

?>
        <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
            <h1><?= $week->toString();?></h1>
            <?php if ($_SESSION['type']===3):?>
                <form class="d-flex flex-row align-items-center" action="/cabinet/calendar/week" method="get">
                    <input type="hidden" name="month" value="<?= $week->month ?>">
                    <input type="hidden" name="week" value="<?= $week->week ?>">
                    <input type="hidden" name="year" value="<?= $week->year ?>">
                    <label class="w-50">Agenda du docteur : </label>
                    <select class="form-control w-50" onchange="this.form.submit()" name="idPraticien">
                        <option value="---">---</option>
                        <?php foreach($ListePraticiens as $praticien):?>
                            <option <?php if(isset($_GET['idPraticien'])&&$praticien->getIdPraticien()==$_GET['idPraticien']) echo "selected=\"selected\" ";?>value=<?=$praticien->getIdPraticien()?>><?=$praticien->getPrenom().' '.$praticien->getNom()?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            <?php endif;?>
            <a href="/cabinet/calendar/month?month=<?= $week->month?>&year=<?=$week->year?><?php if(isset($_GET['idPraticien'])) echo '&idPraticien='.$_GET['idPraticien']?>">Affichage Mois</a>
            <div>
                <a href="/cabinet/calendar/week?month=<?= $week->previousWeek()->month?>&year=<?= $week->previousWeek()->year; ?>&week=<?= $week->previousWeek()->week; ?><?php if(isset($_GET['idPraticien'])) echo '&idPraticien='.$_GET['idPraticien']?>" class="btn btn-primary">&lt</a>
                <a href="/cabinet/calendar/week?month=<?= $week->nextWeek()->month?>&year=<?= $week->nextWeek()->year; ?>&week=<?= $week->nextWeek()->week; ?><?php if(isset($_GET['idPraticien'])) echo '&idPraticien='.$_GET['idPraticien']?>" class="btn btn-primary">&gt</a>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="heures d-flex flex-column align-items-end">
                <div class="bufferth"></div>
                <div class="bufferbuffer"></div>
                <div class="txtHeures d-flex flex-column justify-content-between">
                    <?php for($i=0;$i<11;$i++):?>
                    <p><?=($i+9)."h00"?></p>
                    <?php endfor;?>
                </div>
                <div class="bufferHeuresBas"></div>
                <div class="bufferbufferBas"></div>
            </div>
            <table class="calendar__weektable">
                <tr>
                    <th class="thbufferHeuresLeft"></th>
                    <?php foreach($week->days as $k => $day):
                        $date = (clone $start)->modify("+" . ($k) ." days");
                    ?>
                    <th  <?= $week->withinMonth($date) ? '' :  'class= calendar__othermonth'?>>
                        <div class="calendar__hour"><?= $day.'<br>'.$date->format('d') ?></div>
                    </th>
                    <?php endforeach; ?>
                    <th class="thbufferHeuresRight"></th>
                </tr>
                <tr>
                    <th class="buffer thbufferHeuresLeft"></th>
                    <?php foreach($week->days as $k => $day): ?>
                        <td class="buffer"></td>
                    <?php endforeach; ?>
                    <th class="buffer thbufferHeuresRight"></th>
                </tr>

            <?php for($i = 0; $i < 10; $i++): ?>
                <tr>
                    <td class="tdbufferHeuresLeft"></td>
                    <?php foreach($week->days as $k => $day):
                        $date = (clone $start)->modify("+" . ($k) ." days");
                    ?>
                    <td class="calendar__hour <?php if($i==0){echo "olcontainer";} ?>">
                    <?php if($i==0):?>
                    <div class="overlay ol<?= $day ?>">
                        <?php
                        if(!empty($listeRDV)):
                            foreach($listeRDV as $rdv):
                                $debut=new DateTime($rdv->getStart());
                                $heure=new DateTime($rdv->getStart());
                                $heure=$heure->format("H:i");
                                if($_SESSION['type']===1){
                                    $interlocuteur=$praticienDAO->get($rdv->getIdPraticien());
                                    $interlocuteur= "Dr. ".strtoupper($interlocuteur->getNom())." ".ucfirst($interlocuteur->getPrenom());
                                    $address="/cabinet/patient/";
                                }elseif($_SESSION['type']===2){
                                    $interlocuteur=$patientDAO->get($rdv->getIdPatient());
                                    $interlocuteur=strtoupper($interlocuteur->getNom())." ".ucfirst($interlocuteur->getPrenom());
                                    $address="/cabinet/praticien/";
                                }elseif($_SESSION['type']===3){
                                    $interlocuteur=$patientDAO->get($rdv->getIdPatient());
                                    $interlocuteur=strtoupper($interlocuteur->getNom())." ".ucfirst($interlocuteur->getPrenom());
                                    $address="/cabinet/secretaire/";
                                }
                                if($debut->format('N')==$k+1):
                                    $classeStart="h".$debut->format('H').$debut->format('i');
                                    ?>
                                    <a href="<?= $address ?>rdv/display?idRdv=<?= $rdv->getIdRdv(); ?>" class="creneau <?=$classeStart?> d<?=$rdv->getDuree()?>"> <?=$heure." - ".$interlocuteur?></a>
                                <?php endif;
                            endforeach; 
                        endif;?>
                    </div>
                    <?php endif;?>
                    </td>
                    <?php endforeach; ?>
                    <td class="tdbufferHeuresRight"></td>
                </tr>
            <?php endfor; ?>
                <tr>
                    <?php for($i=0;$i<9;$i++):
                        if($i==0):
                        ?>
                    <td class="calendar__buffer tdbufferHeuresLeft"></td>
                        <?php elseif($i==8): ?>
                    <td class="calendar__buffer tdbufferHeuresRight"></td>
                        <?php else: ?>
                    <td class="calendar__buffer"></td>
                        <?php endif;
                    endfor;?>
                </tr>
                <tr class="bufferFin"></tr>
            </table>
            <div class="heures d-flex flex-column align-items-start">
            <div class="bufferth"></div>
                <div class="bufferbuffer"></div>
                <div class="txtHeures d-flex flex-column justify-content-between">
                    <?php for($i=0;$i<11;$i++):?>
                    <p><?=($i+9)."h00"?></p>
                    <?php endfor;?>
                </div>
                <div class="bufferHeuresBas"></div>
                <div class="bufferbufferBas"></div>
            </div>
        </div>
