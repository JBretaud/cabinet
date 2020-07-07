<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'DemandeRdv.php';
class demandeRdvDAO{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function create(DemandeRdv $demandeRdv){
        $query = $this->pdo->prepare("INSERT INTO demanderdv (idDemande, idPatient, idPraticien, idService, date) VALUES (:idDemande, :idPatient, :idPraticien, :idService, :date)");
        $query->execute([
            'idDemande' => $demandeRdv->getIdDemande(),
            'idPatient' => $demandeRdv->getIdPatient(),
            'idPraticien' => $demandeRdv->getIdPraticien(),
            'idService' => $demandeRdv->getIdService(),
            'date' => $demandeRdv->getDate(),
        ]);
    }

    public function getPatient($idPatient){
        $query = $this->pdo->prepare("SELECT * FROM demanderdv WHERE idPatient = :idPatient");
        $query->execute([
            'idPatient' => $idPatient,
        ]);
        $data = $query->fetchAll();
        $results=[];
        foreach($data as $attributes){
            array_push($results,new DemandeRdv($attributes));
        }
        return $results;
    }
    public function get($idService){
        $query = $this->pdo->prepare("SELECT * FROM demanderdv WHERE idService = :idService");
        $query->execute([
            'idService' => $idService,
        ]);
        return new DemandeRdv($query->fetch());
    }
}