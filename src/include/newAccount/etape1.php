    <?php
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'idDAO.php';
        $idDAO=new idDAO($pdo);
        $ListeLogins=$idDAO->loginliste();
        $ListeEmails=$idDAO->emailListe();

    ?>
    <form id="creaCompte" class="d-flex flex-column align-items-center" method='post' action='/cabinet/account/new/etape1R'>
        <h1> Création de compte </h1>
        <h2> Etape 1 / 2</h2>
        <div class="mb-4 form-group d-flex flex-row justify-content-between">
            <label for="login">Identifiant de Connexion :</label>
            <div class="d-flex flex-column align-items-end">
                <div class="d-flex flex-row align-items-start">
                    <p class="valid" v-if="erreur==false&&login">&#10004</p>
                    <p class="errors" v-if="erreur">&#10060</p>
                    <input required v-bind:class="{'mb-4': !erreur}"class="ml-1" v-model="login" type="text" name="login">
                </div>
                <p class="errors" v-if="erreur">Identifiant existant</p>
            </div>
        </div>

        <div class="form-group d-flex flex-row justify-content-between">
            <label for="pass">Mot de Passe:</label>
            <div class="d-flex flex-column align-items-end" v-bind:class="{'mb16px': !mdp}">
                <div class="d-flex flex-row align-items-start">
                    <p v-bind:class="{'mb-4': !mdp}" class="valid" v-if="mdprating>=60">&#10004</p>
                    <p class="errors" v-if="mdprating<60 && mdp">&#10060</p>
                    <input required type="password" v-bind:class="{'mb-4': !mdp}" v-model="mdp" name="pass">
                </div>
                <p v-if="mdp" v-html v-bind:class="{'tresfaible': mdprating<=30,'faible': mdprating>30&&mdprating<60,'moyen':mdprating>=60&&mdprating<80,'bon':mdprating>=80}"><span v-html="secumdp"></span></p>
            </div>
        </div>
        
        <div class="form-group d-flex flex-row justify-content-between">
            <label for="passverif">Veuillez confirmer votre mot de Passe :</label>
            <div class="d-flex flex-column align-items-end" v-bind:class="{'mb16px': !mdpMatch}">
                <div class="d-flex flex-row align-items-start">
                    <p  class="valid" v-if="!mdpMatch&&mdp">&#10004</p>
                    <p  class="errors" v-if="mdpMatch">&#10060</p>
                    <input required v-model="mdpverif" v-bind:class="{'mb-4': !mdpMatch}" type="password" name="passverif">
                </div>
                <p class="mb-3 errors" v-if="mdpMatch" >Mots de passes différents</p>
            </div>
        </div>
        <div class="form-group d-flex flex-row justify-content-between">
            <label for="email">Adresse email :</label>
            <div class="d-flex flex-column align-items-end mb16px">
                <div class="d-flex flex-row align-items-start">
                    <p class="errors" v-if="(!emailOK||!validateEmail)&&email" >&#10060</p>
                    <p class="mb-0 valid" v-if="validateEmail&&emailOK&&email">&#10004</p>
                    <input required v-bind:class="{'mb-4': (emailOK&&validateEmail)||!email}"v-model="email" type="email" name="email">
                </div>
                <p class="errors" v-if="!emailOK" > cet email est déjà associé à un compte</p>
                <p class="errors" v-if="!validateEmail&&email" > e-mail invalide</p>
            </div>
        </div>

        <div class="d-flex flex-row justify-content-end" style="width:28%">
            <button type="submit" :disabled="!buttonOK" v-bind:class="{'disabled': !buttonOK}"  class ="btn btn-primary px-5">Suivant</button>
        </div>
    </form>