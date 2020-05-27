<?php
    session_destroy();
        
            header('Location: /cabinet/accueil?alert=deconnexion');
            exit();
?>