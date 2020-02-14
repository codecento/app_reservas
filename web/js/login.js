$(function() {
	document.getElementById("username").value = localStorage.username || "";

	//Animation for login form link
    $('#login-form-link').click(function(e) {
    	$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

	//Animation for register form link
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

	//Checks if remember me checkbox is checked and save the username in the local storage
	$("#remember").click(function(event) {
		if(document.getElementById("remember").checked == true){
			localStorage.setItem("username",document.getElementById("username").value);
		}
	});

	$("#register-submit").click(function(event){
		var name = $("#username").value;
		var email = $("#email").value;
		var password = $("#password").value;
		var confirmPassword = $("#confirm-password").value;
		
		var flag = false;

		
		if("/^[A-Za-z0-9]{7,15}$/".test(name) == false){
			$("#username").css("border-color","red");
			flag = true;
		}

		if("/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/".test(email) == false){
			$("#email").css("border-color","red");
			flag = true;
		}

		if("/^[A-Za-z0-9]{8,*}$/".test(password) == false){
			$("#password").css("border-color","red");
			flag = true;
		}

		if("/^[A-Za-z0-9]{8,*}$/".test(confirmPassword) == false){
			$("#confirm-password").css("border-color","red");
			flag = true;
		}

		if(flag == true){
			event.preventDefault();
		}
	});

});