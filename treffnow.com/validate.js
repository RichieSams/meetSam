var regExEmail = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-z]{2,4})$/;
var validEmail = false;
var validPassword = false;

function validateLogin() {
    var form = document.getElementById("loginForm");
    
    if (form.name.value == "") {
        alert("Enter Email");
        return false;
    }
    if (form.pass.value == "") {
        alert("Enter Password");
        return false;
    }

    form.pass.value = CryptoJS.SHA256(form.name + form.pass);

    return true;
}

function validateRegistration() {
    var form = document.getElementById("registrationForm");
    var checkEmail = regExEmail.test(form.name.value)
	//var passDig = /[0-9]/.test(form.pass1.value);
	//var passLen = /^[A-Za-z0-9!_-]{6,10}$/.test(form.pass1.value);

    if (form.name.value == "" || form.pass1.value == "" || form.street.value == "" || form.city.value == "" ) {
        alert("Incomplete Registration");
        return false;
    }

	if (form.zip.value == "" || form.state.value == "") {
        alert("Incomplete Registration");
        return false;
    }

    if (! validEmail) {
        alert("Invalid Email");
        return false;
    }

	 if (! validPassword) {
        alert("Invalid Password");
        return false;
    }
	
	if (form.pass1.value != form.pass2.value){
		alert("Passwords do not match");
		return false;
	}

    form.pass1.value = CryptoJS.SHA256(form.name + form.pass1);
    form.pass2.value = CryptoJS.SHA256(form.name + form.pass2);

	return true;
}

function validateTreff () {

    var form = document.getElementById("treffForm");

    if (form.creatorEmail.value == "" || form.treffMateEmail.value == "") {
        alert("Incomplete email information");
        return false;
    }

    if (form.creatorEmail.value == form.treffMateEmail.value) {
        alert("You can not invite yourself to a meeting");
        return false;
    }

	if ( form.street.value == "" || form.city.value == "" || form.zip.value == "" || form.state.value == "") {
        alert("Incomplete Address");
        return false;
    }

    var checkEmail1 = regExEmail.test(form.creatorEmail.value)
    var checkEmail2 = regExEmail.test(form.treffMateEmail.value)
    if (!checkEmail1 || !checkEmail2) {
        alert("Invalid Email");
        return false;
    }

	return true;
}

function validateJoin() {
    var form = document.getElementById("joinForm");
    var checkEmail = regExEmail.test(form.email.value);

    if (form.email.value == "") {
        alert("Enter Email");
        return false;
    }

	if (!checkEmail) {
        alert("Invalid Email");
        return false;
    }

	if (form.street.value == "" || form.city.value == "" || form.zip.value == "" || form.state.value == "") {
        alert("Incomplete Address");
        return false;
    }

	return true;
}

function validateSearch() {
    var form = document.getElementById("joinForm");
    var checkEmail = regExEmail.test(form.email.value);

    if (form.email.value == "") {
        alert("Enter Email");
        return false;
    }

    if (!checkEmail) {
        alert("Invalid Email");
        return false;
    }

    return true;
}

function submitJoin() {
    $('input:checked').closest("form").submit();
}

function validateEmailAjax() {
	var form = document.getElementById("registrationForm");
    var checkEmail = regExEmail.test(form.name.value);

	var email = form.name.value;
	var	passTerm = form.pass1.value;

	$.post("check_email.php", { name: email }, function(responseText) {
				if(! checkEmail) {
					$("span.valEmail").html("<div class='failedEmail'>Email Invalid</div>");
					validEmail = false;
				}
				else if(responseText == '2'){
					$("span.valEmail").html("<div class='failedEmail'>Email Exists</div>");
					validEmail = false;
				}
				else{
					$("span.valEmail").html("<div class='confirmedEmail'>Valid Email</div>");
					validEmail = true;
				}
	});

}

function validatePassAjax() {
	var form = document.getElementById("registrationForm");
    var passDig = /[0-9]/.test(form.pass1.value);
	var passLen = /^[A-Za-z0-9!_-]{6,10}$/.test(form.pass1.value);

	var	pass1 = form.pass1.value;
	
	if(passDig && passLen) {
		$("span.valPass").html("<div class='confirmedEmail'>Valid</div>");
		validPassword = true;
	}
	else{
		$("span.valPass").html("<div class='failedEmail'>Invalid</div>");
		validPassword = false;
	}
	
}

 function validateNewPass() {
	var form = document.getElementById("registrationForm");	
	var passDig = /[0-9]/.test(form.pass1.value);
	var passLen = /^[A-Za-z0-9!_-]{6,10}$/.test(form.pass1.value);

	if (form.pass1.value != form.pass2.value){
		alert("Passwords do not match");
		return false;
	}

	if (! passDig || !passLen) {
        alert("Invalid Password");
        return false;
    }
	
    form.pass1.value = CryptoJS.SHA256(form.name + form.pass1);
    form.pass2.value = CryptoJS.SHA256(form.name + form.pass2);

	return true;
}
