function setEditor(field){
	var roxyFileman = '../plugins/fileman/index.php?integration=custom';
	CKEDITOR.replace(field, {
		filebrowserBrowseUrl:roxyFileman,
		filebrowserImageBrowseUrl:roxyFileman+'?type=image',
		removeDialogTabs: 'link:upload;image:upload',
		contentsCss: 'css/editor.css',
		stylesSet: [],
		language: 'en'
	});
}
function GetXmlHttpObject(){
	var http=null;
	try{
		// Firefox, Opera 8.0+, Safari
		http=new XMLHttpRequest();
	}catch (e){
		//Internet Explorer
		try{
				http=new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e){
				http=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return http;
}
function ajaxRemoveImg(id, tbl, type, folder){
	var url = 'ajaxFunction.php';
	var data = {gettype:"removeImg", id: id, tbl: tbl, type: type, folder: folder};
	$.post(url, data, function(response){
        if(response != ""){
        	location.reload();
        }
    });
}
function ajaxGetSystemVars(name,type){
	var url = 'ajaxFunction.php';
	var data = {gettype:"getDeliveryCharge", name: name, type:type};
	$.post(url, data, function(response){
        if(response != ""){
        	return response;
        }
    });
}
function ajaxCountCartTotal(orderNo){
	var url = 'ajaxFunction.php';
	var data = {gettype:"countCartTotal", orderNo: orderNo};
	$.post(url, data, function(response){
        if(response != ""){
        	return response;
        }
    });
}
function ajaxAddOrderProduct(orderNo, plu, qty){
	var url = 'ajaxFunction.php';
	var data = {gettype:"addOrderProduct", orderNo: orderNo, plu: plu, qty: qty};
	$.post(url, data, function(response){
        if(response){
        	location.reload();
        }else{
			alert(response);
		}
    });
}
function ajaxUpdateOrderProduct(id, orderNo, plu, qty){
	var url = 'ajaxFunction.php';
	var data = {gettype:"updateOrderProduct", id: id, orderNo: orderNo, plu: plu, qty: qty};
	$.post(url, data, function(response){
        if(response){
        	location.reload();
        }else{
			alert("Cannot update product");
		}
    });
}
function ajaxDeleteOrderProduct(id){
	var url = 'ajaxFunction.php';
	var data = {gettype:"deleteOrderProduct", id: id};
	$.post(url, data, function(response){
        if(response){
        	location.reload();
        }else{
        	alert(response);
        }
    });
}