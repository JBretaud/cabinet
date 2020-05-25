<script>
// Creating a new Vue instance and pass in an options object.


var formulaireNewAccount = new Vue({

// A DOM element to mount our view model.

el: '#creaCompte',

// Define properties and give them initial values.

data: {
    login:'',
    requete:'',
    mdp:'',
    secumdp:'Très Faible',
    mdpverif:'',
    buttonOK:false,
    email:'',
    listeEmails:'',
    listeLogins:'',
},

// Functions we will be using.
methods: {
    setlisteLogins:function(){
        
        var test=new Array()
        this.requete.forEach(function(login){
            test.push(login.login);
        });
        this.listeLogins=test;
    },
    setlisteEmails:function(){
        var test=new Array()
        this.requete.forEach(function(email){
            test.push(email.email);
        });
        this.listeEmails=test;
    },
},
computed:{
    erreur:function(){
        var logToTest=this.login;
        var ok=false;
        this.listeLogins.forEach(function(login){
            if (logToTest===login){
                ok=true;
            }
        });
        return ok;  
    },
    emailOK:function(){
        var mailToTest=this.email;
        var ok=true;
        this.listeEmails.forEach(function(email){
            if (mailToTest===email){
                ok=false;
            }
        });
        return ok;  
    },
    buttonOK:function(){
        if(!this.erreur&&!this.mdpMatch&&this.mdprating>=60&&this.login&&this.mdp&&this.validateEmail&&this.emailOK){
            return true;
        }
        return false;
    },
    validateEmail:function(){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(this.email).toLowerCase());
    },
    mdprating:function() {
        var score = 0;
        var pass=this.mdp;
        if (!pass){
            this.secumdp='Votre mot de passe est trop peu sécurisé';
            return score;
        }
        // award every unique letter until 5 repetitions
        var letters = new Object();
        for (var i=0; i<pass.length; i++) {
            letters[pass[i]] = (letters[pass[i]] || 0) + 1;
            score += 5.0 / letters[pass[i]];
        }

        // bonus points for mixing it up
        var variations = {
            digits: /\d/.test(pass),
            lower: /[a-z]/.test(pass),
            upper: /[A-Z]/.test(pass),
            nonWords: /\W/.test(pass),
        }

        variationCount = 0;
        for (var check in variations) {
            variationCount += (variations[check] == true) ? 1 : 0;
        }
        score += (variationCount - 1) * 10;
        if(score<30){
            this.secumdp='Niveau de Sécurité: Trop faible';
        }else if(score<60){
            this.secumdp='Niveau de Sécurité: Trop faible';
        }else if(score<80){
            this.secumdp='Niveau de Sécurité: Moyen ';
        }else{
            this.secumdp='Niveau de Sécurité: Bon';
        }
        return parseInt(score);
    },
    mdpMatch:function(){
        if(this.mdp==this.mdpverif) return false;
        return true;
    }
},
beforeMount(){
    this.requete=<?php 
                    if(isset($ListeLogins)){
                        echo json_encode($ListeLogins);
                    }else{
                        echo "''";
                    }?>,
    this.setlisteLogins();
    this.requete=<?php
                    if(isset($ListeEmails)){
                        echo json_encode($ListeEmails);
                    }else{
                        echo "''";
                    }?>,
    this.setlisteEmails();
},
});

    
</script>