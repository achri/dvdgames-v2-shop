	function fb_logout() {
		// DESTROY USER FROM SESSION
		$.post('index.php/general/logout_fb_user');
		FB.logout();
		return false;
	}
	
	// ASYNC FB FUNCTION ROUTINE
	window.fbAsyncInit = function() {
		FB.init({
			appId      : $.cookie('fb_appid'),
			status     : true, 
			cookie     : true,
			oauth      : true, //outh2 beta for FB Developer
			xfbml      : true
		});
		
		//FB.Event.subscribe('auth.login', function(response) {
		//	window.location.reload();
		//});
		
		FB.Event.subscribe('auth.logout', function(response) {
			window.location.reload();
		});
				
		// MANAGE LOGIN STATUS
		FB.getLoginStatus(function(response) {
			if (response.status=="connected") {
				// SAVE USER TO SESSION
				FB.api('/me', function(user) {
					$.post('index.php/general/login_fb_user',{"fb_data":user});
				});
				// AFTER LOGIN
				$('#fb-login-button').hide();
				$('#fb-logout-button').show();
			} else {
				// BEFORE LOGIN
				$('#fb-login-button').show();
				$('#fb-logout-button').hide();
			}
		});		
		
		//To re-parse all of the XFBML on a page
		FB.XFBML.parse();
	};
	
	// FB Javascript SDK Include non ASYNC
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));	