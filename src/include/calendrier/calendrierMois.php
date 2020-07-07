<?php
            require '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Date'.DIRECTORY_SEPARATOR.'Month.php';
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
            require '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'loggedToObjects.php';
            $praticienDAO=new praticienDAO($pdo);
            $patientDAO=new patientDAO($pdo);
            $rdvDAO=new rdvDAO($pdo);
            $ListePraticiens=$praticienDAO->getListe();
            try {
                $month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null, $_GET['week'] ?? null);
            } catch (\Exception $e){
                $month = new App\Date\Month();
            }
            
            if ($month->getStartingDay()->format('w')!=1){
                $start= $month->getStartingDay()->modify('last monday');
            } else{
                $start= $month->getStartingDay();
            }

            $end=(clone $start)->modify("+".$month->getWeeks()." weeks");
            $end->modify("+6 days");
            $end->modify("+20 hours");
            $listeRDV = null;

            if(isset($_GET['idPraticien'])&&$_GET['idPraticien']!="---"){
                $personne=$praticienDAO->get($_GET['idPraticien']);
            }
            if(isset($personne)){
                $listeRDV=$rdvDAO->getSpan($start,$end,$personne);
                
            }
        ?>
        <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
            <h1><?= $month->toString();?></h1>
            <?php if ($_SESSION['type']===3):?>
                <form class="d-flex flex-row align-items-center" action="/cabinet/calendar/month" method="get">
                    <input type="hidden" name="month" value="<?= $month->month ?>">
                    <input type="hidden" name="week" value="<?= $month->week ?>">
                    <label class="w-50">Agenda du docteur : </label>
                    <select class="form-control w-50" onchange="this.form.submit()" name="idPraticien">
                        <option value="---">---</option>
                        <?php foreach($ListePraticiens as $praticien):?>
                            <option <?php if(isset($_GET['idPraticien'])&&$praticien->getIdPraticien()==$_GET['idPraticien']) echo "selected=\"selected\" ";?>value=<?=$praticien->getIdPraticien()?>><?=$praticien->getPrenom().' '.$praticien->getNom()?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            <?php endif;
                $ajd=new DateTime();
                
                if(!isset($_GET['year'])||($ajd->format("Y")==$_GET['year']&&$ajd->format("m")==$_GET['month'])){
                    $lien="/cabinet/calendar/week?year=".$ajd->format('Y')."&month=".$ajd->format('m')."&week=".$ajd->format('W');
                }else{
                    $lien="/cabinet/calendar/week?year=".$month->year."&month=".$month->month;
                }
                if(isset($_GET['idPraticien'])) $lien.= '&idPraticien='.$_GET['idPraticien'];
            ?>
            <a href="<?=$lien?>">Affichage Semaine</a>
            <div>
                <a href="/cabinet/calendar/month?&month=<?= $month->previousMonth()->month?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt</a>
                <a href="/cabinet/calendar/month?&month=<?= $month->nextMonth()->month?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt</a>
            </div>
        </div>

        <div class=" d-flex flex-column calendar__table calendar__table--<?= $month->getWeeks()+1 ?>weeks">
            <?php for($i = 0; $i < $month->getWeeks()+1; $i++): ?>
            <div class="d-flex flex-row tr">
                <?php foreach($month->days as $k => $day):
                   $date = (clone $start)->modify("+" . ($k + $i * 7) ." days"); 
                ?>
                
                <div class= "position-relative <?= $month->withinMonth($date) ? '' :  'calendar__othermonth';?> <?= ($i===0) ? ' row1 ':'rowx ';?><?=($day==="Lundi") ? ' col1 ' : ' col ';?> td d-flex flex-column" >
                    <div class="backgroundTop position-absolute">
                        <?php if ($i===0):?> <div class="calendar__weekday"><?= $day; ?></div> <?php endif;?>
                        <div class="calendar__day"><?= $date->format('d') ?></div>
                    </div>
                    <ul class="ListeRdv w-100" <?= ($i===0) ? "style=\"margin-top:60px\"" : '' ;?>>
                        
                        <?php if(!empty($listeRDV)):
                            foreach($listeRDV as $rdv):
                                if($rdv->getDate()===$date->format('Y-m-d')):
                                $heure=new DateTime($rdv->getStart());
                                $heure=$heure->format("H:i");
                                if ($rdv->getLabel()=== null){
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
                                }else{
                                    
                                    $interlocuteur=$rdv->getLabel();
                                    $address="/cabinet/".(($_SESSION['type']===2) ? 'praticien/' : 'secretaire/' );
                                }
                                
                                
                                ?>
                            <li>
                                <a href="<?= $address ?>rdv/display?idRdv=<?= $rdv->getIdRdv();?>"><?= $heure." - ".$interlocuteur; ?></a>
                            </li>
                            <?php endif;
                        endforeach;
                        endif;?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
        </div>
        <?php if($_SESSION['type'] === 2) : ?>
            <a class = "d-flex align-items-center justify-content-center rounded-circle position-absolute" href="/cabinet/praticien/rdvperso/new" style = "z-index:10; top:98%; left:98%; transform:translate(-100%,-100%); height:50px; width:50px; background-color:rgb(48, 186, 190); color:#fff; text-decoration:none; font-size:1.5em"><span style="margin-top:-5px">+</span></a>
        <?php endif; ?>
      
        <script src="" async defer></script>
