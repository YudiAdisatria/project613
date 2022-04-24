require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Navbar Fixed
window.onscroll = function() {
    const header = document.querySelector('header');
    const fixedNav = header.offsetTop;

    if(window.pageYOffset > fixedNav){
        header.classList.add('navbar-fixed');
    }else{
        header.classList.remove('navbar-fixed');
    }
}

//Hamburger
const hambuger = document.querySelector('#hambuger');
const navMenu = document.querySelector('#nav-menu');

hambuger.addEventListener('click', function() {
    hambuger.classList.toggle('hambuger-active');
    navMenu.classList.toggle('hidden');
});

//search
function tablesearch(){
    let input,filter , table, tr, td, txtValue;

    input = document.getElementById("myInput");
    filter = input.value.toUppercase();
    table = document.getElementById("myTable");
    tr = table.getElementById("tr");

    for(let i=0; i < tr.length; i++){
        td = tr[i].getElementById("td")[0];
        if(td) {
            txtValue = td.textcontent || td.innerText;
            if(txtValue.toUppercase().indexOf(filter) > -1){
                tr[i].style.display = "";
            }
            else {
                tr[i].style.display="none";
            }
        }
    }
}

//capture photo
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#showimage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#captureimage").change(function(){
    readURL(this);
});