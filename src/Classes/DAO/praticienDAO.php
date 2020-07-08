<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
class praticienDAO{

    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }

    public function get(?int $id){
        
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
        
        $query=$this->pdo->prepare('SELECT * FROM praticiens');
        $query->execute();
        $data=$query->fetchAll();
        $ListePraticiens=[];
        foreach($data as $praticien){
            array_push($ListePraticiens,new Praticien($praticien));
        }
        return $ListePraticiens;
    }

    public function delete($idPraticien){
        $query = $this->pdo->prepare("DELETE FROM praticiens WHERE idPraticien = :idPraticien");
        $query->execute([
            'idPraticien'=>$idPraticien,
        ]);
    }
    public function create(Praticien $Praticien){
        var_dump($Praticien);
        $query = $this->pdo->prepare("INSERT INTO praticiens (nom,prenom,email,idUtilisateur,cheminPhoto) VALUES (:nom,:prenom,:email,:idUtilisateur,:cheminPhoto)");
        $query->execute([
            'nom'=>$Praticien->getNom(),
            'prenom'=>$Praticien->getPrenom(),
            'email'=>$Praticien->getEmail(),
            'idUtilisateur'=>$Praticien->getIdUtilisateur(),
            'cheminPhoto'=>$Praticien->getCheminPhoto(),
        ]);
    }

}