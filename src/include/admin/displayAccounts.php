<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'idDAO.php';
    $idDAO=new idDAO($pdo);
    $SecListe = $idDAO->getByType(3);
    $MedListe = $idDAO->getByType(2);

    ?>

    <div class="container">
        <div class="row">
            <div class="frame col-xl-7 p-0">
                <div class="title">
                    <h1 style="color:#fff">Liste - Praticiens</h1>
                </div>
                <table class="content">
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <th>idPraticien</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach($MedListe as $Med):?>
                    <tr>
                        <td><?=$Med->getLogin()?></td>
                        <td><?=$Med->getEmail()?></td>
                        <td><?=$Med->getIdPraticien()?></td>
                        <td><a class="btn btn-secondary" href="/cabinet/admin/accounts/modify?idUtilisateur=<?=$Med->getIdUtilisateur()?>">Modifier le Mot de Passe</a></td>
                        <td><a class="btn btn-alert" href="/cabinet/admin/accounts/delete?idUtilisateur=<?=$Med->getIdUtilisateur()?>">Supprimer le Compte</a></td>
                    </tr>
                    <?php endforeach;?>
                </table>
                
            </div>
            <div class="col-xl-1"></div>
            <div class="frame p-0 col-xl-4">
                <div class="title">
                <h1 style="color:#fff">Nouveau Compte</h1>
                </div>
                <div class="content p-3">
                    <form action="/cabinet/admin/accounts/create" method="POST">
                        <div class="form-group w-100">
                            <label for="login">Login :</label>
                            <input class="form-control" type="text" name="login" required>
                        </div>
                        <div class="form-group w-100">
                            <label for="login">Email :</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>
                        <input type="hidden" value="2" name="idTypeUtilisateur">
                        <div class="form-group w-100">
                            <label for="login">Mot de Passe :</label>
                            <input class="form-control" type="password" name="pass" required>
                        </div>
                        <div class="form-group w-100">
                            <label for="login">Mot de Passe (confirmation) :</label>
                            <input class="form-control" type="password" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Créer</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="frame col-xl-7 p-0">
                <div class="title">
                    <h1 style="color:#fff">Liste - Secretaires</h1>
                </div>
                <table class="content">
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach($SecListe as $Sec):?>
                    <tr>
                        <td><?=$Sec->getLogin()?></td>
                        <td><?=$Sec->getEmail()?></td>
                        <td><a class="btn btn-secondary" href="/cabinet/admin/accounts/modify?idUtilisateur=<?=$Sec->getIdUtilisateur()?>">Modifier le Mot de Passe</a></td>
                        <td><a class="btn btn-alert" href="/cabinet/admin/accounts/delete?idUtilisateur=<?=$Sec->getIdUtilisateur()?>">Supprimer le Compte</a></td>
                    </tr>
                    <?php endforeach;?>
                </table>
                
            </div>
            <div class="col-xl-1"></div>
            <div class="frame p-0 col-xl-4">
                <div class="title">
                <h1 style="color:#fff">Nouveau Compte</h1>
                </div>
                <div class="content p-3">
                    <form action="/cabinet/admin/accounts/create" method="POST">
                        <div class="form-group w-100">
                            <label for="login">Login :</label>
                            <input class="form-control" type="text" name="login" required>
                        </div>
                        <div class="form-group w-100">
                            <label for="login">Email :</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>
                        <input type="hidden" value="3" name="idTypeUtilisateur">
                        <div class="form-group w-100">
                            <label for="login">Mot de Passe :</label>
                            <input class="form-control" type="password" name="pass" required>
                        </div>
                        <div class="form-group w-100">
                            <label for="login">Mot de Passe (confirmation) :</label>
                            <input class="form-control" type="password" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Créer</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>