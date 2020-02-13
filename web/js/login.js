$(function() {
	document.getElementById("username").value = localStorage.username;
	document.getElementById("password").value = localStorage.password;


    $('#login-form-link').click(function(e) {
    	$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

	$("#remember").click(function(event) {
		if(document.getElementById("remember").checked == true){
			localStorage.setItem("username",document.getElementById("username").value);
			localStorage.setItem("password",document.getElementById("password").value);
		}
	});

});