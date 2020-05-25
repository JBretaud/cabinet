<?php
class praticienDAO{

    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }

    public function get(?int $id){
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
        $query=$this->pdo->prepare('SELECT * FROM praticiens WHERE idPraticien=:idPraticien;');
        $query->execute(['idPraticien'=>$id]);
        $data=$query->fetch();
        if (!empty($data)){
            $praticien=new Praticien($data);
            return $praticien;
        }else {
            return null;
        }
    }
    public function getListe(){
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
        $query=$this->pdo->prepare('SELECT * FROM praticiens');
        $query->execute();
        $data=$query->fetchAll();
        $ListePraticiens=[];
        foreach($data as $praticien){
            array_push($ListePraticiens,new Praticien($praticien));
        }
        return $ListePraticiens;
    }

}