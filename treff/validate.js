var regExEmail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

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
	var passDig = /[0-9]/.test(form.pass1.value);
	var passLen = /^[A-Za-z0-9_]{6,10}$/.test(form.pass1.value);

    if (form.name.value == "" || form.pass1.value == "" || form.street.value == "" || form.city.value == "" ) {
        alert("Incomplete Registration");
        return false;
    }

	if (form.zip.value == "" || form.state.value == "") {
        alert("Incomplete Registration");
        return false;
    }

    if (checkEmail != true) {
        alert("Invalid Email");
        return false;
    }

	 if (passDig != true || passLen != true) {
        alert("Invalid Password");
        return false;
    }
	
	if (form.pass1.value != form.pass1.value){
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
