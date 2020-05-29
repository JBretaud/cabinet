<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ligneOrdonnanceDAO.php';
class ligneOrdonnanceDAO{
    

    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }
    public function create(LigneOrdonnance $ligneOrdonnance){
        var_dump($ligneOrdonnance);
        $query = $this->pdo->prepare('INSERT INTO ligneordonnance(idOrdonnance , idMedicament, posologie)VALUES(:idOrdonnance , :idMedicament, :posologie);');
        $query->execute([
            'posologie'=>$ligneOrdonnance->getPosologie(),
            'idMedicament'=>$ligneOrdonnance->getIdMedicament(),
            'idOrdonnance'=>$ligneOrdonnance->getIdOrdonnance(),
        ]);
    }
}
?>