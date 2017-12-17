//===== Cart Function =====
function addToCart(plu){
    var qty = 1;
    if($('#quantity-select-'+plu).val()>1){
        qty = $('#quantity-select-'+plu).val();
    }
    var url = 'ajaxFunction.php';
    var data = {gettype:"addToCart", plu: plu, qty: qty};
    $.post(url, data, function(response){
        if(response != ""){
            alert(response);
        }
    });
}
function changeCartQty(plu){
	var url = 'ajaxFunction.php';
	var data = {gettype:"changeCartQty", plu: plu, qty: $("#quantity-select-"+plu).val()};
	$.post(url, data, function(response){
        if(response != ""){
        	location.reload();
        }
    });
}
function removeCart(plu){
	var url = 'ajaxFunction.php';
	var data = {gettype:"removeCart", plu: plu};
	$.post(url, data, function(response){
        if(response != ""){
        	location.reload();
        }
    });
}

function setCoupon(){
    var url = 'ajaxFunction.php';
    var data = {gettype:"setCoupon", code: $("#coupon_code").val()};
    $.post(url, data, function(response){
        if(response != ""){
            alert(response);
            location.reload();
        }
    });
}

function removeCoupon(){
    var url = 'ajaxFunction.php';
    var data = {gettype:"setCoupon", code: "CLEAR"};
    $.post(url, data, function(response){
        if(response != ""){
            alert(response);
            location.reload();
        }
    });
}

//===== Validation =====
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
function isEmailExist(email){
    var url = 'ajaxFunction.php';
    var data = {gettype:"checkEmailExist", email: email};
    $.post(url, data, function(response){
        if(response!="0"){
            $("#email_msg").html(response);
            $("#checkEmailExist").val("1");
        }else{
            $("#email_msg").html("");
            $("#checkEmailExist").val("0");
        }
    });
}

function memberLogout(){
    var url = 'ajaxFunction.php';
    var data = {gettype:"memberLogout"};
    $.post(url, data, function(response){
        if(response != ""){
            alert(response);
            location.reload();
        }
    });
}