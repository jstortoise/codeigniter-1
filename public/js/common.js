/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $(".right-menu-button").click(function(){
        $(".pop-over-menu").slideToggle(500);
    });
    
    $('.nav > li > a').click(function(){
        localStorage.setItem('selectMessageBox', $(this).text());
    });
    
    if(localStorage.getItem('selectMessageBox') != 'undefined')
    {
        $('a').parent('li').removeClass('active');
    }
    $("a:contains('"+localStorage.getItem('selectMessageBox')+"')").trigger('click'); 
});
/*
window.onload;
    {
        time = new Date().getUTCHours();
        minute = new Date().getUTCMinutes();
        timezone = new Date().getTimezoneOffset();
        if (timezone > 0) {
            hour= time*60+minute+timezone;
            currenttime= hour/60;
        }else
            hour= time*60+minute-timezone;
        currenttime= hour/60;
        console.log(currenttime);
        var theDiv = document.getElementById("wraptextelement");
        var content;
        if (currenttime >= 5 && currenttime < 10) {
            document.getElementById("cover_picture").style.background = "url(<?php echo base_url(); ?>public/images/morning.png)";
            content = document.createTextNode("Morning");
        }else if(currenttime >= 10 && currenttime < 16){
            document.getElementById("cover_picture").style.background = "url(<?php echo base_url(); ?>public/images/afternoon.png)";
            content = document.createTextNode("Afternoon");
        }else if (currenttime >= 16 && currenttime < 19){
            document.getElementById("cover_picture").style.background = "url(<?php echo base_url(); ?>public/images/evening.png)";
            content = document.createTextNode("Evening");
        }else if(currenttime >= 19 && currenttime < 24) {
            document.getElementById("cover_picture").style.background = "url(<?php echo base_url(); ?>public/images/night.png)";
            content = document.createTextNode("Night");
            theDiv.style.color = 'white';
        }else if(currenttime >= 24 && currenttime < 30) {
            document.getElementById("cover_picture").style.background = "url(<?php echo base_url(); ?>public/images/night.png)";
            content = document.createTextNode("Mid Night");
            theDiv.style.color = 'white';
        }
        var breakLine = document.createElement("br");
        var dummyText =  document.createTextNode("Dummy text for 1 liner or 2 liner");
        theDiv.appendChild(content);
        theDiv.appendChild(breakLine);
        theDiv.appendChild(dummyText);
    }
*/