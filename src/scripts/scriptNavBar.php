<script>
    const boutonMenu = document.querySelector("#boutonMenu");
    const navBar = document.querySelector("#navbar");
    const navbarItems = document.querySelectorAll(".navbar-item");
    const navbarBrand = document.querySelectorAll(".navbar-brand");
    window.addEventListener('load',()=>{
        displayNav();
        boutonMenu.addEventListener('click',toggleMenu);
    })
    var winWidth;
    var toggled = false;
    window.addEventListener('resize',()=>{
        displayNav();
        
    })
    function displayNav(){
        winWidth = window.innerWidth;
        
        if(winWidth<992){
            boutonMenu.style.display='block';
            navbarItems.forEach((item)=>{
                item.style.display='none';
            })
            navbarBrand.forEach((item)=>{
                item.style.marginTop='10px';
            })
        }else{
            if(toggled){
                toggled = false;
                burgerMenu = document.getElementById('burgerMenu');
                burgerMenu.remove();
            }
            
            boutonMenu.style.display='none';
            navbarItems.forEach((item)=>{
                item.style.display='inline';
            })
            navbarBrand.forEach((item)=>{
                item.style.marginTop='0px';
            })
        }
    }
    function toggleMenu(){
        
        if(!toggled){
            toggled = true;
            var burgerMenu = insertAfter(document.createElement('div'),navBar);
            navBar.style.marginBottom = "0px";
            navBar.className = "navbar navbar-dark bg-primary menu";
            burgerMenu.id = 'burgerMenu';
            burgerMenu.className = 'd-flex flex-column align-items-end menu';
            burgerMenu.style.backgroundColor = 'rgb(48, 186, 190)';
            burgerMenu.width = "100%";
            navbarItems.forEach((item)=>{
                burgerItem = burgerMenu.appendChild(item.cloneNode());
                burgerItem.style.display = "inline-block";
                burgerItem.innerHTML = item.innerHTML;
                burgerItem.className += " my-2 mr-3";
                if(item.id="idButton"){
                    burgerItem.addEventListener('click',()=>{
                        toggled = false;
                        burgerMenu = document.getElementById('burgerMenu');
                        burgerMenu.remove();
                        navBar.className = "navbar navbar-dark bg-primary mb-3 menu";
                        demo._data.show_auth = !demo._data.show_auth;
                    })
                }
            })
            
        }else{
            toggled = false;
            burgerMenu = document.getElementById('burgerMenu');
            burgerMenu.remove();
            navBar.className = "navbar navbar-dark bg-primary mb-3 menu";
        }
    }
    function insertAfter(newNode, referenceNode) {
        return referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
        
    }

</script>