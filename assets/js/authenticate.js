$(function() {
  var authResult = $.ajax({
		type: "POST",
		url: "/savDarbas/php/authenticate.php",
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
		Logout();
	}
});