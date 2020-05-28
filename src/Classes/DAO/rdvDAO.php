<?php
    class rdvDAO{
        private $pdo;

        public function __construct($pdo){
            $this->pdo=$pdo;
        }

        public function create(?Rdv $rdv){
            $query = $this->pdo->prepare('INSERT INTO rdv(idPatient, idPraticien, start, Description,Date)VALUES(:idPatient, :idPraticien, :start, :Description, :Date);');
            $query->execute([
                'idPatient'=>$rdv->getIdPatient(),
                'idPraticien'=>$rdv->getIdPraticien(),
                'start'=>$rdv->getStart(),
                'Description'=>$rdv->getDescription(),
                'Date'=>$rdv->getDate()
            ]);
        }
        /**
        * param $idRdv
        *@throws Exception;
        */
        public function get(?int $idRdv){
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
            $query = $this->pdo->prepare('SELECT * FROM rdv WHERE idRdv=:idRdv;');
            $query->execute([
                'idRdv'=>$idRdv,
            ]);
            $data=$query->fetch();
            try{
                return new Rdv($data);
            }catch(\Exception $e){
                throw $e;
            }
            
        }
        /**
        * param $rdv
        *@throws Exception;
        */
        public function delete(?Rdv $rdv){
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
            $query = $this->pdo->prepare('DELETE FROM rdv WHERE idRdv=:idRdv;');
            $query->execute([
                'idRdv'=>$rdv->getIdRdv(),
            ]);
        }
        public function update(?Rdv $rdv){
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
            $query = $this->pdo->prepare('UPDATE rdv SET idPatient=:idPatient, idPraticien=:idPraticien, Description=:Description, Date=Date, duree=:duree, start=:start WHERE idRdv=:idRdv;');
            $query->execute([
                'idRdv'=>$rdv->getIdRdv(),
                'idPatient'=>$rdv->getIdPatient(),
                'idPraticien'=>$rdv->getIdPraticien(),
                'Description'=>$rdv->getDescription(),
                'duree'=>$rdv->getDuree(),
                'Date'=>$rdv->getDate(),
                'start'=>$rdv->getStart(),
            ]);
        }

        public function getNextRdv(?int $idPatient){
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
            $ajd=new DateTime();
            $query=$this->pdo->prepare('SELECT * FROM rdv WHERE idPatient=:idPatient && start > :start ORDER BY start;');
            $query->execute([
                'idPatient'=>$idPatient,
                'start'=> $ajd->format("Y-m-d H:i"),
            ]);
            $data= $query->fetch();
            if(!empty($data)){
                return new Rdv($data);
            }else{
                return null;
            }
        }

        public function getAllDayRdv(?Day $day,?int $idPraticien){
            $date=$day->getStart();
            $query=$this->pdo->prepare('SELECT * FROM rdv WHERE Date=:Date AND idPraticien=:idPraticien;');
            $query->execute([
                'Date'=>$date->format('Y-m-d'),
                'idPraticien'=>$idPraticien
                ]);
            $data= $query->fetchAll();
            $ListeRdv=[];
            foreach($data as $rdv){
                array_push($ListeRdv,new Rdv($rdv));
            }
            return $ListeRdv;
        }

        public function getSpan(?Datetime $start,?Datetime $end,$personne){
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
            if ($personne instanceof Patient){
                
                $idPatient=$personne->getIdPatient();
                $spanTitulaire="idPatient=:idPatient";
                $array_query=[
                    'Start'=>$start->format("Y-m-d H:i"),
                    'End'=>$end->format("Y-m-d H:i"),
                    'idPatient'=>$idPatient,
                ];

            }
            if ($personne instanceof Praticien){
                $idPatient=null;
                $idPraticien=$personne->getIdPraticien();
                $spanTitulaire="idPraticien=:idPraticien";
                $array_query=[
                    'Start'=>$start->format("Y-m-d H:i"),
                    'End'=>$end->format("Y-m-d H:i"),
                    'idPraticien'=>$idPraticien,
                ];
            }
            $query=$this->pdo->prepare('SELECT * FROM rdv WHERE Start>:Start AND Start<:End AND '.$spanTitulaire.' ORDER BY start;');
            $query->execute($array_query);
            $data = $query->fetchAll();
            $ListeRdv=[];
            foreach($data as $rdv){
                array_push($ListeRdv,new Rdv($rdv));
            }
            return $ListeRdv;
        }
    }