$(document).ready(function(){

   $("#set").click(function(){
    showpopup();
   });
    $("#set2").click(function(){
    showpopup2();
   });
   $("#close").click(function(){
    hidepopup();
   });
   $("#close2").click(function(){
    hidepopup2();
   });
});


function showpopup()
{
   $("#loginform").fadeIn();
   $("#loginform").css({"visibility":"visible","display":"block"});
}
function showpopup2()
{
   $("#loginform2").fadeIn();
   $("#loginform2").css({"visibility":"visible","display":"block"});
}
function hidepopup()
{
   $("#loginform").fadeOut();
   $("#loginform").css({"visibility":"hidden","display":"none"});
}
function hidepopup2()
{
    $("#loginform2").fadeOut();
   $("#loginform2").css({"visibility":"hidden","display":"none"});
}