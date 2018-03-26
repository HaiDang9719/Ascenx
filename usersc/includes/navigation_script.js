$(document).ready(function() {
    
    $("#search-box").keyup(function() {

        $.ajax({
            type: "POST",
            url: "/KTproj/users/navigation_script.php",
            data: 'keyword=' + $(this).val(),
            beforeSend: function() {
                $("#search-box").css("background", "#FFF no-repeat 165px");
                $("#suggesstion-box").hide();
                console.log("beforesend");
            },
            success: function(data) {
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(data);
                $("#search-box").css("background", "#FFF");
                console.log("success");

            }
        });
        
        var url = "/KTproj/users/searchResult.php?keyword="+$(this).val();
    if (event.keyCode == 13) {
        
                                $.ajax
                                ({
                                    type:'post',
                                    url:'/KTproj/users/searchResult.php',
                                    
                                    data:{

                                        search:"search",
                                        keyword:"R",
                                     },
                                    success:function(response) {
   
                                    }
                                });
                         
        location.href = url;
    }
        
    });
    

});

function disappear() {

    $("#suggesstion-box").hide();
    console.log("disappear");
}
//To select country name
function selectCountry(val) {
    $("#search-box").val(val);
    $("#suggesstion-box").hide();
    console.log("selectCountry");
}

