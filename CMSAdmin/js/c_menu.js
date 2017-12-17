/*
Simple JQuery menu.
HTML structure to use:

Notes:

1: each menu MUST have an ID set. It doesn't matter what this ID is as long as it's there.
2: each menu MUST have a class 'menu' set. If the menu doesn't have this, the JS won't make it dynamic

Optional extra classnames:

noaccordion : no accordion functionality
collapsible : menu works like an accordion but can be fully collapsed
expandfirst : first menu item expanded at page load

<ul id="menu1" class="menu [optional class] [optional class]">
<li><a href="#">Sub menu heading</a>
<ul>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
...
...
</ul>
<li><a href="#">Sub menu heading</a>
<ul>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
...
...
</ul>
...
...
</ul>

Copyright 2008 by Marco van Hylckama Vlieg

web: http://www.i-marco.nl/weblog/
email: marco@i-marco.nl

Free for non-commercial use
*/

/*function initMenus() {
	//docname = parent.location.href.substring(parent.location.href.lastIndexOf("/")+4, parent.location.href.lastIndexOf("/")+7);
	docname = parent.location.href.substring(parent.location.href.lastIndexOf("/")+1);	*/
function QueryString(name)
	{
	    var AllVars = window.location.search.substring(1);
	    var Vars = AllVars.split("&");
	    for (i = 0; i < Vars.length; i++)
	    {
        var Var = Vars[i].split("=");
       if (Var[0] == name) return Var[1];
   }
    return "";
}

function initMenus() {
//docname = parent.location.href.substring(parent.location.href.lastIndexOf("/")+4, parent.location.href.lastIndexOf("/")+9);
	//docname = document.getElementById('menuid').value;
	//alert(docname);
	var menuid = "menu"+QueryString("cid");
	$('ul.c_menu ul').hide();

if (menuid != ""){

	$('#'+menuid+' ul').show();
}





	$.each($('ul.c_menu'), function(){
		$('#' + this.id + '.expandfirst ul:first').show();
	});
	$('ul.c_menu li a').click(
		function() {
			var checkElement1 = $(this).next();
			var parent1 = this.parentNode.parentNode.id;
			if((checkElement1.is('ul')) && (checkElement1.is(':visible'))) {
				//console.log('true');
				$('#' + parent1 + ' ul:visible').slideUp('normal');
			}
		}
	);
	$('ul.c_menu li a').click(
		function() {
			//this.slideUp('normal');
				var checkElement = $(this).next();
			var parent = this.parentNode.parentNode.id;

			if($('#' + parent).hasClass('noaccordion')) {
				$(this).next().slideToggle('normal');
				return false;
			}
			if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
				if($('#' + parent).hasClass('collapsible')) {
					$('#' + parent + ' ul:visible').slideUp('normal');
				}
				return false;
			}
			if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
				$('#' + parent + ' ul:visible').slideUp('normal');
				checkElement.slideDown('normal');
				return false;
			}
		}
	);
	$('ul.c_menu li ul li a').hover(
		 function () {
			var checkElement = $(this).next();
			if((checkElement.is('ul'))) {
				checkElement.show();
			}
		  },
		  function () {
			 var checkElement = $(this).next();
			if((checkElement.is('ul'))) {
				checkElement.hide();
			}
		  }
	);

}
$(document).ready(function() {initMenus();});