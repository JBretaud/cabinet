<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Ordonnance.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'LigneOrdonnance.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ligneOrdonnanceDAO.php';

class ordonnanceDAO{
    

    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }

    /**
     * @param $ordonnance
     * @throws \Exception
     */

    public function create(Ordonnance $ordonnance){
        include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
        $ligneOrdonnanceDAO=new ligneOrdonnanceDAO($pdo);
        $preListeIdOrdo=$this->getIdListe();
        $query = $this->pdo->prepare('INSERT INTO ordonnance(idPraticien, idPatient, dateOrdonnance)VALUES(:idPraticien, :idPatient, :dateOrdonnance);');
        $query->execute([
            'idPatient'=>$ordonnance->getIdPatient(),
            'idPraticien'=>$ordonnance->getIdPraticien(),
            'dateOrdonnance'=>$ordonnance->getDateOrdonnance(),
        ]);
        $postListeIdOrdo=$this->getIdListe();
        if(!in_array ( end($postListeIdOrdo), $preListeIdOrdo ) ){
            $latestId=end($postListeIdOrdo)['idOrdonnance'];
            $_SESSION['idOrdonnance']=$latestId;
        }else{
            throw new Exception ("Probleme ID");
        }
        foreach($ordonnance->getLignes() as $ligne){
            
            $ligne->setIdOrdonnance($latestId);
            try{
                $ligneOrdonnanceDAO->create($ligne);
            }catch(Exception $e){

            }
        }

        
    }
    public function update(Ordonnance $ordonnance){
        include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
        
        $ligneOrdonnanceDAO=new ligneOrdonnanceDAO($pdo);
        
        // delete des lignes d'ordonnance préexistantes:

        $ligneOrdonnanceDAO->delete($ordonnance->getIdOrdonnance());
        
        foreach($ordonnance->getLignes() as $ligne){
            $ligne->setIdOrdonnance($ordonnance->getIdOrdonnance());
            try{
                $ligneOrdonnanceDAO->create($ligne);
            }catch(Exception $e){
                
            }
        }
        $query=$this->pdo->prepare("UPDATE ordonnance SET dateOrdonnance=:dateOrdonnance,idPraticien=:idPraticien,idPatient=:idPatient WHERE idOrdonnance=:idOrdonnance");
        $query->execute([
            'idOrdonnance'=>$ordonnance->getIdOrdonnance(),
            'dateOrdonnance'=>$ordonnance->getDateOrdonnance(),
            'idPatient'=>$ordonnance->getIdPatient(),
            'idPraticien'=>$ordonnance->getIdPraticien(),
        ]);
    }
    public function delete($idOrdonnance){
        include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
        $ligneOrdonnanceDAO=new ligneOrdonnanceDAO($pdo);
        $ligneOrdonnanceDAO->delete($idOrdonnance);
        $query = $this->pdo->prepare('DELETE FROM ordonnance WHERE idOrdonnance=:idOrdonnance');
        $query->execute([
            'idOrdonnance'=>$idOrdonnance
        ]);
    }
    private function getIdListe(){
        $query = $this->pdo->prepare('SELECT idOrdonnance FROM ordonnance ORDER BY idOrdonnance');
        $query->execute();
        $data=$query->fetchAll();
        return $data;
    }
    public function getPatient($idPatient) :array {
        include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
        $ligneOrdonnanceDAO=new ligneOrdonnanceDAO($pdo);
        $query = $this->pdo->prepare('SELECT * FROM ordonnance WHERE idPatient=:idPatient');
        $query->execute([
            'idPatient'=>$idPatient,
        ]);
        $data=$query->fetchAll();
        $return=[];
        foreach($data as $ordonnance){
            $ordonnance['lignes']=$ligneOrdonnanceDAO->getOrdonnance($ordonnance['idOrdonnance']);
            array_push(new Ordonnance($ordonnance),$return);
        }
        function CmpOnDate(Ordonnance $ordo1,Ordonnance $ordo2){
            $date1=new DateTime($ordo1->getDateOrdonnance());
            $date2=new DateTime($ordo2->getDateOrdonnance());
            if($date1===$date2) return 0;
            return ($date1<$date2) ?  -1 : 1;
        }
        usort($return,"CmpOnDate");
        return $return;
    }
    
}

?>