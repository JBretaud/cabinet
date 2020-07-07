<div class="container frame">
    <div class="row">
        <div class="title col-12">
            <h1 style="color:#fff">Rendez-vous</h1>
        </div>
    </div>
    <div class="row content">
        <form class="col-12 pt-4" id= "form" action="/cabinet/praticien/rdvperso/create" method="post">
            <div class="row">
                <div class="col-6">
                    <div class = "form-group w-100">
                        <label for="label">Titre :</label>
                        <input type = "text" name = "label" id="titre" required class="form-control">
                    </div>
                    <div class = "form-group w-100">
                        <label for="date">Date :</label>
                        <input type = "date" name = "date" required class="form-control">
                    </div>
                    <div class = "form-group w-100">
                        <label for="start">Debut :</label>
                        <input type = "time" name = "start" id="start"  min="09:00" max="19:00" required class="form-control">
                    </div>
                    <div class = "form-group w-100">
                        <label for="end">Fin :</label>
                        <input type = "time" id="end" min="09:00" max="19:00" name = "end" required class="form-control">
                    </div>
                    <div class = "form-group w-100">
                        <label for="duree">Durée :</label>
                        <input class="form-control w-100" type="time" name="duree" id="duree" max="10:00">
                    </div>
                    <div class = "form-group w-100 d-flex justify-content-between">
                        <label for="fullDay">Journée Complete :</label>
                        <input id="fullDay" type="checkbox" name="fullDay">
                    </div>
                </div>
                <div class="col-6">
                    <div class = "form-group w-100 h-100 d-flex flex-column pb-3">
                        <label for="duree">Description :</label>
                        <textarea name = "description" class="form-control flex-fill" style="resize:none"></textarea>
                    </div>
                </div>
            </div>
            <div class="row d-flex flex-row justify-content-center">
                <button type="submit" id="submit" class="btn btn-primary px-5" disabled>Réserver</button>
            </div>

        </form>
    </div>
</div>
<script>

    inputTitre = document.querySelector("#titre");
    inputStart = document.querySelector("#start");
    inputDuree = document.querySelector("#duree");
    inputFin = document.querySelector("#end");
    inputFullDay = document.querySelector("#fullDay");
    boutSub = document.querySelector("#submit");
    form = document.querySelector("#form");

    window.addEventListener('load',()=>{

        inputFin.addEventListener('change',function(){
            if(this.value.length > 0){
                inputDuree.disabled = true;
            }else{
                inputDuree.disabled = false;
            }
        })

        inputDuree.addEventListener('change', function(){
            if(this.value.length > 0){
                inputFin.disabled = true;
            }else{
                inputFin.disabled = false;
            }
        })



        inputFullDay.addEventListener('change',function(){
            if(this.checked){
                inputDuree.disabled = true;
            }else{
                inputDuree.disabled = false;
            }
        })

        form.addEventListener('change', function(){
        if((inputStart.value<inputFin.value || inputDuree.value.length>0 && inputStart.value.length>0) && inputTitre.value.length>0){
            boutSub.disabled=false;
        }
        else{
            boutSub.disabled=true;
        }
    });
    });
    
</script>