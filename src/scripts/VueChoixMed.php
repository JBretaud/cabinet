<script>
    var demo = new Vue({

// A DOM element to mount our view model.

el: '.suivi',

// Define properties and give them initial values.

data: {
    show_choixMed: false,
},

// Functions we will be using.

methods: {
    hideChoixMed: function(){
        
        this.show_choixMed = false;
    },
    // Change la valeur de l'attribut "show_tooltip" de l'objet vue demo.
    toggleChoixMed: function(){
        this.show_choixMed = !this.show_choixMed;
    }
}
});
</script>