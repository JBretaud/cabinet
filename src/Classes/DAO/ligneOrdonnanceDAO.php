<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ligneOrdonnanceDAO.php';
class ligneOrdonnanceDAO{
    

    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }
    
    /**
     * param $ligneOrdonnance
    *@throws Exception;
    */
    public function create(LigneOrdonnance $ligneOrdonnance){
        $query = $this->pdo->prepare('INSERT INTO ligneordonnance(idOrdonnance , idMedicament, posologie)VALUES(:idOrdonnance , :idMedicament, :posologie);');
        $query->execute([
            'posologie'=>$ligneOrdonnance->getPosologie(),
            'idMedicament'=>$ligneOrdonnance->getIdMedicament(),
            'idOrdonnance' => $ligneOrdonnance->getIdOrdonnance(),
        ]);
    }
    public function getOrdonnance($idOrdonnance){
        $query = $this->pdo->prepare('SELECT * FROM ligneordonnance WHERE idOrdonnance = :idOrdonnance;');
        $query->execute([
            'idOrdonnance'=>$idOrdonnance,
        ]);
        $data=$query->fetchAll();
        $return=[];
        foreach($data as $ligne){
            array_push($return,new LigneOrdonnance($ligne));
        }
        return $return;
    }
    public function delete($idOrdonnance){
        $query = $this->pdo->prepare('DELETE FROM ligneordonnance WHERE idOrdonnance=:idOrdonnance');
        $query->execute([
            'idOrdonnance'=>$idOrdonnance,
        ]);
    }
}
?>