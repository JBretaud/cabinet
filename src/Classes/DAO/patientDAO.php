<?php
class patientDAO{

    private $pdo;
    public function __construct($pdo){
        $this->pdo=$pdo;
    }

    public function create(?Patient $patient){
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
        // echo $patient->getDateNaissance();
        $query = $this->pdo->prepare('INSERT INTO clients(nom,prenom,dateNaissance,voie,ville,cp,telephone,email,idUtilisateur)VALUES(:nom,:prenom,:dateNaissance,:voie,:ville,:cp,:telephone,:email,:idUtilisateur);');
        $query->execute(
            [
                'nom'=>$patient->getNom(),
                'prenom'=>$patient->getPrenom(),
                'dateNaissance'=>$patient->getDateNaissance(),
                'voie'=>$patient->getVoie(),
                'ville'=>$patient->getVille(),
                'cp'=>$patient->getCp(),
                'telephone'=>$patient->getTelephone(),
                'email'=>$patient->getEmail(),
                'idUtilisateur'=>$patient->getIdUtilisateur(),
            ]);
    }
    public function get(?int $id) {
        $query = $this->pdo->prepare('SELECT * FROM clients WHERE idPatient=:id;');
        $query->execute(
            ['id'=>$id,]);
        $data=$query->fetch();
        if (!empty($data)){
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
            $patient=new Patient($data);
            return $patient;
        }
        return null;
    }
    public function mailExist(?String $email){
        $query = $this->pdo->prepare('SELECT * FROM clients WHERE email=:email;');
        $query->execute([
            'email'=>$email
        ]);
        $data=$query->fetch();
        if(!empty($data)){
            require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
            $patient=new Patient($data);
            return $patient;
        }
        return null;
    }
    public function getId(?Patient $patient){
        $query = $this->pdo->prepare('SELECT * FROM clients WHERE email=:email;');
        $query->execute(['email'=>$patient->getEmail(),]);
        $data=$query->fetch();
        if (!empty($data)){
            return $data['idPatient'];
        }
        return null;
    }
    public function update(?Patient $patient){
        $query = $this->pdo->prepare('UPDATE clients SET nom=:nom, prenom=:prenom, dateNaissance=:dateNaissance, voie=:voie, ville=:ville, cp=:cp, telephone=:telephone, email=:email, idUtilisateur=:idUtilisateur, idPraticien=:idPraticien WHERE idPatient=:idPatient');
        $query->execute([
            'idPatient'=>$patient->getIdPatient(),
            'nom'=>$patient->getNom(),
            'prenom'=>$patient->getPrenom(),
            'dateNaissance'=>$patient->getDateNaissance(),
            'voie'=>$patient->getVoie(),
            'ville'=>$patient->getVille(),
            'cp'=>$patient->getcp(),
            'telephone'=>$patient->getTelephone(),
            'email'=>$patient->getEmail(),
            'idUtilisateur'=>$patient->getIdUtilisateur(),
            'idPraticien'=>$patient->getIdPraticien()
        ]);
    }
    public function getListe(){
        $query = $this->pdo->prepare('SELECT idPatient, nom, prenom, dateNaissance, voie, ville, cp FROM clients');
        $query->execute();
        return $query->fetchAll();
        
    }

}