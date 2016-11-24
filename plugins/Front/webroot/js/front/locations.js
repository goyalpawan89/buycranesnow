
    function ajaxCall() {
        this.send = function(data, url, method, success, type) {
          type = type||'json';
          var successRes = function(data) {
              success(data);
          }

          var errorRes = function(e) {
              console.log(e);
              alert("Error found \nError Code: "+e.status+" \nError Message: "+e.statusText);
              $('#loader').modal('hide');
          }
            $.ajax({
                url: url,
                type: method,
                data: data,
                success: successRes,
                error: errorRes,
                dataType: type,
                timeout: 60000
            });

          }

        }

function locationInfo() {
    var rootUrl = "http://iamrohit.in/lab/php_ajax_country_state_city_dropdown/api.php";
    var call = new ajaxCall();
    this.getCities = function(id) {
        $(".city option:gt(0)").remove();
        var url = rootUrl+'?type=getCities&stateId=' + id;
        var method = "post";
        var data = {};
        $('.city').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.city').find("option:eq(0)").html("Select City");
            if(data.tp == 1){
                $.each(data['result'], function(key, val) {
                    var option = $('<option />');
                    option.attr('value', val).text(val);
                     option.attr('cityid', key);
                    $('.city').append(option);
                });
                $(".city").prop("disabled",false);
            }
            else{
                 alert(data.msg);
            }
        });
    };

    this.getStates = function(id) {
        $(".state option:gt(0)").remove(); 
        $(".city option:gt(0)").remove(); 
        var url = rootUrl+'?type=getStates&countryId=' + id;
        var method = "post";
        var data = {};
        $('.state').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.state').find("option:eq(0)").html("Select State");
            if(data.tp == 1){
                $.each(data['result'], function(key, val) {
                    var option = $('<option />');
                        option.attr('value', val).text(val);
                        option.attr('stateid', key);
                    $('.state').append(option);
                });
                $(".state").prop("disabled",false);
            }
            else{
                alert(data.msg);
            }
        }); 
    };

    this.getCountries = function() {
        var url = rootUrl+'?type=getCountries';
        var method = "post";
        var data = {};
        $('.country').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            //$('.country').find("option:eq(0)").html("Select Country");
            console.log(data);
            if(data.tp == 1){
                $.each(data['result'], function(key, val) {
                    var option = $('<option />');
                    option.attr('value', val).text(val);
                     option.attr('countryid', key);
                    $('.country').append(option);
                });
                $(".country").prop("disabled",false);
            }
            else{
                alert(data.msg);
            }
        }); 
    };

}

$(function() {
var loc = new locationInfo();
loc.getCountries();
 $(".country").on("change", function(ev) {
        var countryId = $("option:selected", this).attr('countryid');
        if(countryId != ''){
        loc.getStates(countryId);
        }
        else{
            $(".state option:gt(0)").remove();
        }
    });
 $(".state").on("change", function(ev) {
        var stateId = $("option:selected", this).attr('stateid');
        if(stateId != ''){
        loc.getCities(stateId);
        }
        else{
            $(".city option:gt(0)").remove();
        }
    });
});


