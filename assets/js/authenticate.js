$(function() {
  var authResult = $.ajax({
		type: "POST",
		url: "/savDarbas/login/authenticate.php",
		async: false
	}).responseText.replace(/(\r\n|\n|\r)/gm,"").split(" ");
		
	if(authResult[0] == "true")
	{
		var permissions = $.ajax({
			type: "POST",
			url: "/savDarbas/php/permissions.php",
			async: false
		}).responseText.replace(/(\r\n|\n|\r)/gm,"").split(" ");
		permissions.forEach(function(permission){
			if(permission !== "")
			{
				$("#" + permission).css({'display': 'inline-block'});
			}
		});
		for(var permission in permissions)
		{
			if(permission !== "")
			{
				$("#" + permission).css({'display': 'inline-block'});
			}
		}
	}
	else
	{
		window.alert("Deja, per ilgai buvote neaktyvus ir Jusu sesija baigesi.");
		Logout();
	}
});