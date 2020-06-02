<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Ordonnance.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'LigneOrdonnance.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ligneOrdonnanceDAO.php';

class ordonnanceDAO{
    

    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }
    public function create(Ordonnance $ordonnance){
        include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
        
            $ligneOrdonnanceDAO=new ligneOrdonnanceDAO($pdo);
            $preListeIdOrdo=$this->getIdListe();
            $query = $this->pdo->prepare('INSERT INTO ordonnance(idPraticien, idPatient)VALUES(:idPraticien, :idPatient);');
            $query->execute([
                'idPatient'=>$ordonnance->getIdPatient(),
                'idPraticien'=>$ordonnance->getIdPraticien(),
            ]);
            $postListeIdOrdo=$this->getIdListe();
            if(!in_array ( end($postListeIdOrdo), $preListeIdOrdo ) ){
                $latestId=end($postListeIdOrdo)['idOrdonnance'];
                $_SESSION['idOrdonnance']=$latestId;
            }
            foreach($ordonnance->getLignes() as $ligne){
                
                $ligne->setIdOrdonnance($latestId);
                $ligneOrdonnanceDAO->create($ligne);
            }

        
    }
    public function update(Ordonnance $ordonnance){
        include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
        
        $ligneOrdonnanceDAO=new ligneOrdonnanceDAO($pdo);
        
        // delete des lignes d'ordonnance préexistantes:

        $ligneOrdonnanceDAO->delete($ordonnance->getIdOrdonnance());

        
        
        foreach($ordonnance->getLignes() as $ligne){
            $ligne->setIdOrdonnance($ordonnance->getIdOrdonnance());
            $ligneOrdonnanceDAO->create($ligne);
        }
    }
    public function delete($ordonnance){
        include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
        $ligneOrdonnanceDAO=new ligneOrdonnanceDAO($pdo);
        $ligneOrdonnanceDAO->delete($ordonnance->getIdOrdonnance());
        $query = $this->pdo->prepare('DELETE FROM ordonnance WHERE idOrdonnance=:idOrdonnance');
        $query->execute([
            'idOrdonnance'=>$ordonnance->getIdOrdonnance(),
        ]);
    }
    private function getIdListe(){
        $query = $this->pdo->prepare('SELECT idOrdonnance FROM ordonnance ORDER BY idOrdonnance');
        $query->execute();
        $data=$query->fetchAll();
        return $data;
    }
}

?>