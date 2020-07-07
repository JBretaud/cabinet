<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'User.php';
    class idDAO{
        private $pdo;
        public function __construct($pdo){
            $this->pdo=$pdo;
        }
    
        public function login($login,$pass){
            
            $query = $this->pdo->prepare('SELECT * FROM utilisateurs WHERE login=:login');
            $query->execute(
            [
                'login'=>$login,
            ]);
            $data = $query->fetch();
            
            if(!empty($data)){
                if(password_verify($pass,$data['pass'])){
                    return new User($data);
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }

        public function loginliste(){
            $query = $this->pdo->prepare('SELECT login FROM utilisateurs');
            $query->execute();
            return $query->fetchAll();
        }

        public function emailListe(){
            $query = $this->pdo->prepare('SELECT email FROM utilisateurs');
            $query->execute();
            return $query->fetchAll();
        }

        public function create($login,$pass,$type,$email){
            $query = $this->pdo->prepare('INSERT INTO utilisateurs(login,pass,email,idTypeUtilisateur)VALUES(:login,:pass,:email,:idTypeUtilisateur);');
            $query->execute(
                [
                    'login'=>$login,
                    'pass'=>$pass,
                    'email'=>$email,
                    'idTypeUtilisateur'=>$type
                ]);
        }
        public function get(?int $idUtilisateur=null,?String $login=null){
            if($login===null){
                $query = $this->pdo->prepare('SELECT * FROM utilisateurs WHERE idUtilisateur=:idUtilisateur;');
                $query->execute(['idUtilisateur'=>$idUtilisateur]);
                $data = $query->fetch();
                if(!empty($data)){
                    return new User($data);
                }else{
                    return null;
                }
            }else if($idUtilisateur===null){
                $query = $this->pdo->prepare('SELECT * FROM utilisateurs WHERE login=:login;');
                $query->execute(['login'=>$login]);
                $data = $query->fetch();
                if(!empty($data)){
                    return new User($data);
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }
        public function update($User){
            $requete="idUtilisateur=".$User->getIdUtilisateur().", login='".$User->getLogin()."', pass='".$User->getPass()."', idTypeUtilisateur=".$User->getIdTypeUtilisateur()."";
            if(!empty($User->getEmail()))  $requete.=", email=\"".$User->getEmail()."\"";
            if(!empty($User->getIdPatient())){
                $requete.=", idPatient=".$User->getIdPatient();
            }
            if(!empty($User->getIdPraticien())){
                $requete.=", idPraticien=".$User->getIdPraticien();
            }
            $requete='UPDATE utilisateurs SET '.$requete.' WHERE idUtilisateur='.$User->getIdUtilisateur().';';
            echo '<br>'.$requete;
            $query = $this->pdo->prepare($requete);
            $query->execute();
        }

        public function getByType($idTypeUtilisateur){
            $query = $this->pdo->prepare("SELECT * FROM utilisateur WHERE idTypeUtilisateur = :idTypeUtilisteur");
            $query->execute([
                "idTypeUtilisateur" => $idTypeUtilisateur,
            ]);
        }
    }
?>