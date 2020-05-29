<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Med.php';
class medDAO{
    

    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }
    public function getListe(){
        $query = $this->pdo->prepare('SELECT * FROM medicaments;');
        $query->execute();
        $data = $query->fetchAll();
        $ListeMeds=[];
        
        foreach ($data as $attributes){
            array_push($ListeMeds,new Med($attributes));
        }
        return $ListeMeds;
    }
    public function get($id){
        $query = $this->pdo->prepare('SELECT * FROM medicaments WHERE idMedicament=:idMedicament;');
        $query->execute([
            'idMedicament'=>$id,
        ]);
        $data=$query->fetch();
        return new Med($data);
    }
    
}

?>