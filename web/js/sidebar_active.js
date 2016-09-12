$(document).ready(function(){
	$("a[class='active']").removeClass("active");
	
	var sidebarActive = $("input[name='sidebar_active']").val();
	
	switch(sidebarActive) {
	    case "home":
	    	$("a[id='home']").addClass("active");
	        break;
	    case "liste_dj":
	    	$("a[id='liste_dj']").addClass("active");
	        break;
	    case "profil":
	    	$("a[id='profil']").addClass("active");
	        break;
	}
});
