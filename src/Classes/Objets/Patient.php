<?php
class Patient{
    
    private $idPatient;
    private $nom;
    private $prenom;
    private $dateNaissance;
    private $voie;
    private $cp;
    private $ville;
    private $telephone;
    private $email;
    private $idUtilisateur;
    private $idPraticien;

    public function __construct(?Array $properties){
        $this->hydrate($properties);
    }

    public function hydrate(array $donnees)
{
  foreach ($donnees as $key => $value)
  {
    if(!empty($value)){
        // On récupère le nom du setter correspondant à l'attribut.
        $method = 'set'.ucfirst($key);
        // Si le setter correspondant existe.
        if (method_exists($this, $method))
        {
        // On appelle le setter.
        $this->$method($value);
        }
    }
  }
}
    public function toString() :string {
        $attributes=[];
        foreach($this as $key=>$value){
            $attributes[$key]=$value;
        }
        $output = implode(', ', array_map(
            function ($v, $k) {
                if(is_array($v)){
                    return $k.'[]='.implode('&'.$k.'[]=', $v);
                }else{
                    return $k.'='.$v;
                }
            }, 
            $attributes, 
            array_keys($attributes)
        ));
        return $output;
    }

    // GETTERS

    public function getIdPatient(){
        return $this->idPatient;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getDateNaissance(){
        return $this->dateNaissance;
    }
    public function getVoie(){
        return $this->voie;
    }
    public function getcp(){
        return $this->cp;
    }
    public function getVille(){
        return $this->ville;
    }
    public function getTelephone(){
        return $this->telephone;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getIdUtilisateur(){
        return $this->idUtilisateur;
    }
    public function getIdPraticien(){
        return $this->idPraticien;
    }

    //SETTERS


    public function setNom($nom){
        $this->nom = $nom;
    }
    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }
    public function setDateNaissance($dateNaissance){
        $this->dateNaissance = $dateNaissance;
    }
    public function setVoie($voie){
        $this->voie = $voie;
        
    }
    public function setcp($cp){
        $this->cp = $cp;
        
    }
    public function setVille($ville){
        $this->ville = $ville;
       
    }
    public function setTelephone($telephone){
        $this->telephone = $telephone;
        
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setIdUtilisateur($idUtilisateur){
        $this->idUtilisateur = $idUtilisateur;
    }
    public function setIdPatient($idPatient){
        $this->idPatient = $idPatient;
    }
    public function setIdPraticien($idPraticien){
        $this->idPraticien = $idPraticien;
    }

}
?>