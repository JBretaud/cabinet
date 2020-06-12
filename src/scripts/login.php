<?php 
echo '<pre>';
print_r ($_POST);
echo '</pre>';
if(!empty($_POST['login'])){
    require_once '../src/Classes/DAO/idDAO.php';

    $auth=new idDAO($pdo);


    $user = $auth->login($_POST['login'],$_POST['pass']);
    var_dump($user);
    if (!empty($user)){
        $_SESSION['login']=$user->getLogin();
        $_SESSION['type']=$user->getIdTypeUtilisateur();
        $_SESSION['id']=$user->getIdUtilisateur();
        if($_SESSION['type']===2){
            $_SESSION['idPraticien']=$user->getIdPraticien();
        }
        header('Location: /cabinet/accueil');
        exit();
    }else{
        header('Location: /cabinet/accueil/errorLogin');
        exit();
    }
}else{
    
    header('Location: /cabinet/accueil');
    exit();
}

