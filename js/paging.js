function showPaging(totalPage, page, htmlPath, other){
	//var htmlPath = "index.php";

	if(document.getElementById("paging")){
		if(page>1)
			txt = '<li><a href="'+htmlPath+'?page='+(page-1)+''+other+'">&lt; 上一頁</a></li>';
		else
			txt = '<li><a href="javascript:void(0);">&lt; 上一頁</a></li>';
			
		if(page<6 || totalPage<=10){
			for(i=1; i<=10 && i<=totalPage; i++){
				if(i!=page)
					txt += '<li><a href="'+htmlPath+'?page='+i+''+other+'">'+i+'</a></li>';
				else
					txt += '<li><a href="javascript:void(0);" class="using">'+i+'</a></li>';
			}
		}else{
			if(page>=totalPage-5){
				for(i=totalPage-9; i<=totalPage; i++){
					if(i!=page)
						txt += '<li><a href="'+htmlPath+'?page='+i+''+other+'">'+i+'</a></li>';
					else
						txt += '<li><a href="javascript:void(0);" class="using">'+i+'</a></li>';
				}
			}else{
				for(i=page-4; i<=page+5 && i<=totalPage; i++){
					if(i!=page)
						txt += '<li><a href="'+htmlPath+'?page='+i+''+other+'">'+i+'</a></li>';
					else
						txt += '<li><a href="javascript:void(0);" class="using">'+i+'</a></li>'
				}
			}
		}
		if(page<totalPage)
			txt += '<li><a href="'+htmlPath+'?page='+(page+1)+''+other+'">下一頁 &gt;</a></li>';
		else
			txt += '<li><a href="javascript:void(0);">下一頁 &gt;</a></li>';

		document.getElementById("paging").innerHTML = txt;
	}
}
function goToPage(url,page=1){
	if($("#page_input").length >0 && $("#page_input").val()>1){
		page = $("#page_input").val();
	}
	window.location.replace(url+"&page="+page);
}