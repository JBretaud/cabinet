<div id="bandeau" class="px-5 d-flex flex-row align-items-start justify-content-between">
    <img class="img" src="/cabinet/src/img/img1.png" alt="">
    <div id="actu" class="d-flex flex-column align-items-center">
        <div id="logoNom" class="d-flex flex-row align-items-center">
            <img src="/cabinet/src/img/logo.png" alt="">
            <div class="d-flex flex-column justify-content-center">
            <p class="pl-4">Cabinet</p>
            <p class="pl-4">Médical</p>
            </div>
        </div>
        <h1>Actualités</h1>
    </div>
    <img class="img" src="/cabinet/src/img/img2.png" alt="">
</div>

    
<div id="articles" class="p-4 d-flex flex-row align-items-start justify-content-around">
    <div class="article d-flex flex-column align-items-center">
        <h2>Article 1</h2>
        <div>
            <p>
            Quod cum ita sit, paucae domus studiorum seriis cultibus antea celebratae nunc ludibriis ignaviae torpentis exundant, vocali sonu, perflabili tinnitu fidium resultantes. denique pro philosopho cantor et in locum oratoris doctor artium ludicrarum accitur et bybliothecis sepulcrorum ritu in perpetuum clausis organa fabricantur hydraulica, et lyrae ad speciem carpentorum ingentes tibiaeque et histrionici gestus instrumenta non levia.
            </p>
            <p>
            Duplexque isdem diebus acciderat malum, quod et Theophilum insontem atrox interceperat casus, et Serenianus dignus exsecratione cunctorum, innoxius, modo non reclamante publico vigore, discessit.
            </p>
        </div>
    </div>

    <div class="article d-flex flex-column align-items-center">
    <h2>Article 2</h2>
        <div>
            <p>
            Et quoniam apud eos ut in capite mundi morborum acerbitates celsius dominantur, ad quos vel sedandos omnis professio medendi torpescit, excogitatum est adminiculum sospitale nequi amicum perferentem similia videat, additumque est cautionibus paucis remedium aliud satis validum, ut famulos percontatum missos quem ad modum valeant noti hac aegritudine colligati, non ante recipiant domum quam lavacro purgaverint corpus. ita etiam alienis oculis visa metuitur labes.
            </p>
            <p>
            Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.
            </p>
            <p>
            Quae dum ita struuntur, indicatum est apud Tyrum indumentum regale textum occulte, incertum quo locante vel cuius usibus apparatum. ideoque rector provinciae tunc pater Apollinaris eiusdem nominis ut conscius ductus est aliique congregati sunt ex diversis civitatibus multi, qui atrocium criminum ponderibus urgebantur.
            </p>
        </div>
    </div>
    <div class="article d-flex flex-column align-items-center">
        <h2>Article 3</h2>
        <div>
            <p>
            Illud tamen te esse admonitum volo, primum ut qualis es talem te esse omnes existiment ut, quantum a rerum turpitudine abes, tantum te a verborum libertate seiungas; deinde ut ea in alterum ne dicas, quae cum tibi falso responsa sint, erubescas. Quis est enim, cui via ista non pateat, qui isti aetati atque etiam isti dignitati non possit quam velit petulanter, etiamsi sine ulla suspicione, at non sine argumento male dicere? Sed istarum partium culpa est eorum, qui te agere voluerunt; laus pudoris tui, quod ea te invitum dicere videbamus, ingenii, quod ornate politeque dixisti.
            </p>
            <p>
            Haec et huius modi quaedam innumerabilia ultrix facinorum impiorum bonorumque praemiatrix aliquotiens operatur Adrastia atque utinam semper quam vocabulo duplici etiam Nemesim appellamus: ius quoddam sublime numinis efficacis, humanarum mentium opinione lunari circulo superpositum, vel ut definiunt alii, substantialis tutela generali potentia partilibus praesidens fatis, quam theologi veteres fingentes Iustitiae filiam ex abdita quadam aeternitate tradunt omnia despectare terrena.
            </p>
        </div>
    </div>
    
</div>

<?php

if (isset($_SESSION['login'])){
    if ($_SESSION['type']=="patient"){
        
    }elseif($_SESSION['type']=="praticien"){

    }elseif($_SESSION['type']=="admin"){

    }else{
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'error404.php';
    }
}