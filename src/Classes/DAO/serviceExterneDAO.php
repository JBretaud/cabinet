<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'ServiceExterne.php';
class serviceExterneDAO{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getType($type){
        $query = $this->pdo->prepare("SELECT * FROM servicesexternes WHERE type=:type");
        $query->execute([
            'type'=>$type
        ]);
        $data = $query->fetchAll();
        return $data;
    }

    public function getAllTypes(){
        $query = $this->pdo->prepare("SELECT DISTINCT type FROM servicesexternes");
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }
    public function getService($idService){
        $query = $this->pdo->prepare("SELECT * FROM servicesexternes WHERE idService = :idService");
        $query->execute([
            'idService' => $idService,
        ]);
        $data = $query->fetch();
        return new ServiceExterne($data);
    }
    public function getAllServices(){
        $query = $this->pdo->prepare("SELECT * FROM servicesexternes");
        $query->execute();
        $data=$query->fetchAll();
        $results = [];
        foreach( $data as $attributes){
            array_push($results,new ServiceExterne($attributes));
        }
        return $results;
    }

    
}