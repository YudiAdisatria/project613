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

//List Ruangan
$(document).ready(function() {
    $('#gedung').on('change', function() {
        var ruanganID = $(this).val();
        console.log(ruanganID);
        $('#ruangan').empty();
        $('#ruangan').append('<option label> Processing </option>');
        if(ruanganID) {
            $.ajax({
                url: '/dashboard/ruangans/'+ruanganID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                    if(data){
                        $('#ruangan').empty();
                        $('#ruangan').append('<option value="">'+'ruangan'+'</option>');
                        $.each(data, function(key, ruangan){
                            $('select[name="ruangan"]').append('<option value="'+ ruangan.ruangan +'">' + ruangan.ruangan+ '</option>');
                        });
                    }else{
                        $('#ruangan').empty();
                    }
                }
            });
        }else{
            $('#ruangan').empty();
        }
    });
});

$(document).ready(function() {
    $('#gedung1').on('change', function() {
        var ruanganID = $(this).val();
        console.log(ruanganID);
        $('#ruangan1').empty();
        $('#ruangan1').append('<option label> Processing </option>');
        if(ruanganID) {
            $.ajax({
                url: '/dashboard/ruangans/'+ruanganID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                    if(data){
                        $('#ruangan1').empty();
                        $.each(data, function(key, ruangan){
                            $('select[name="ruangan"]').append('<option value="'+ ruangan.ruangan +'">' + ruangan.ruangan+ '</option>');
                        });
                    }else{
                        $('#ruangan1').empty();
                    }
                }
            });
        }else{
            $('#ruangan1').empty();
        }
    });
});