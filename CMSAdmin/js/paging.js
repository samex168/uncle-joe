function showPaging(totalPage, page, htmlPath, other){
	//var htmlPath = "index.php";

	if(document.getElementById("paging")){
		if(page>1)
			txt = '<span class="pagingText"><a href="'+htmlPath+'?page='+(page-1)+''+other+'">&nbsp;Prev&nbsp;</a></span>\n';
		else 
			txt = '<span class="pagingText"><a href="#">&nbsp;Prev&nbsp;</a></span>\n';
			
		if(page<6 || totalPage<=10){
			for(i=1; i<=10 && i<=totalPage; i++){
				if(i!=page)
					txt += '<span class="pagingText"><a href="'+htmlPath+'?page='+i+''+other+'">&nbsp;'+i+'&nbsp;</a></span>\n';
				else
					txt += '<span class="pagingTextTarget">&nbsp;'+i+'&nbsp;</span>\n';
			}
		}else{
			if(page>=totalPage-5){
				for(i=totalPage-9; i<=totalPage; i++){
					if(i!=page)
						txt += '<span class="pagingText"><a href="'+htmlPath+'?page='+i+''+other+'">&nbsp;'+i+'&nbsp;</a></span>\n';
					else
						txt += '<span class="pagingTextTarget">&nbsp;'+i+'&nbsp;</span>\n';
				}
			}else{
				for(i=page-4; i<=page+5 && i<=totalPage; i++){
					if(i!=page)
						txt += '<span class="pagingText"><a href="'+htmlPath+'?page='+i+''+other+'">&nbsp;'+i+'&nbsp;</a></span>\n';
					else
						txt += '<span class="pagingTextTarget">&nbsp;'+i+'&nbsp;</span>\n';
				}
			}
		}
		if(page<totalPage)
			txt +='<span class="pagingText"><a href="'+htmlPath+'?page='+(page+1)+''+other+'">&nbsp;Next&nbsp;</a></span>\n';
		else
			txt +='<span class="pagingText"><a href="#">&nbsp;Next&nbsp;</a></span>\n';
		document.getElementById("paging").innerHTML = txt;
	}
}