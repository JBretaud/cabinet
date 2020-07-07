<?php
    class DemandeRdv{
        private $idDemande;
        private $idPatient;
        private $idPraticien;
        private $idService;
        private $date;

        public function __construct(?Array $properties){
            $this->hydrate($properties);
        }
    
        public function hydrate(array $donnees)
        {
            foreach ($donnees as $key => $value)
            {
                if(!empty($value)){
                    // On récupère le nom du setter correspondant à l'attribut.
                    $method = 'set'.ucfirst($key);
                    // Si le setter correspondant existe.
                    if (method_exists($this, $method))
                    {
                    // On appelle le setter.
                    $this->$method($value);
                    }
                }
            }
        }
        public function getIdDemande(){
            return $this->idDemande;
        }
        public function getIdPatient(){
            return $this->idPatient;
        }
        public function getIdPraticien(){
            return $this->idPraticien;
        }
        public function getIdService(){
            return $this->idService;
        }
        public function getDate(){
            return $this->date;
        }

        public function setIdDemande(?String $idDemande){
            $this->idDemande = $idDemande;
        }
        public function setIdPatient(?String $idPatient){
            $this->idPatient = $idPatient;
        }
        public function setIdPraticien(?String $idPraticien){
            $this->idPraticien = $idPraticien;
        }
        public function setIdService(?String $idService){
            $this->idService = $idService;
        }
        public function setDate(?String $date){
            $this->date = $date;
        }

    }