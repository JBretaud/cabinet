<?php
class Rdv{
    private $idRdv;
    private $idPatient;
    private $idPraticien;
    private $start;
    private $duree;
    private $description;
    private $date;
    private $label;
    /**
    * param $attributes
    *@throws Exception;
    */
    public function __construct(?array $attributes){
    try{
        $this->hydrate($attributes);
        if (is_null($this->duree)){
            $this->duree = 20;
        }
    }catch(\Exception $e){
        throw $e;
    }
    }
    /**
    * param $attributes
    *@throws Exception;
    */
    public function hydrate($attributes){
        foreach ($attributes as $key => $value)
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

    public function getIdRdv(){
        return $this->idRdv;
    }
    public function getIdPatient(){
        return $this->idPatient;
    }
    public function getIdPraticien(){
        return $this->idPraticien;
    }
    public function getStart(){
        return $this->start;
    }
    public function getDuree(){
        return $this->duree;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getDate(){
        return $this->date;
    }
    public function getLabel(){
        return $this->label;
    }

    public function setIdRdv($idRdv){
       $this->idRdv=$idRdv;
    }
    public function setIdPatient($idPatient){
        $this->idPatient=$idPatient;
    }
    public function setIdPraticien($idPraticien){
        $this->idPraticien=$idPraticien;
    }
    public function setStart($start){
        $this->start=$start;
    }
    public function setDuree($duree){
        if(empty($duree)){
            $this->duree = 20;
        }else{
            $this->duree = $duree;
        }
    }
    public function setDescription($description){
        $this->description=$description;
    }
    public function setDate($date){
        $this->date=$date;
    }
    public function setLabel($label){
        $this->label=$label;
    }

    
} 