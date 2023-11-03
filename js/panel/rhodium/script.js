
function myD(){
    if ($("body").hasClass("sunmode")) {
    console.log("asa");
    $(".normalmode").css("display","block");
    $(".darkmode").css("display","none");
    }
    else {
    $(".normalmode").css("display","none");
    $(".darkmode").css("display","block");
    }
    
    }
    
    $(document).ready(function($) {
    var mode = localStorage.getItem('mode');
    if (mode) 
    $('body').addClass(mode);
    
    $(".darkmode").click(function() {
    $("body").addClass("sunmode");
    localStorage.setItem('mode', 'sunmode');
    $('#darkMenuAktif').addClass('active');
    
    $(".darkmode").css("display","none");
    $(".normalmode").css("display","block");
    
    });
    
    $(".normalmode").click(function() {
    $("body").removeClass("sunmode");
    localStorage.setItem('mode', null);
    $('#darkMenuAktif').addClass('');
    
    $(".darkmode").css("display","block");
    $(".normalmode").css("display","none");
    });
    });