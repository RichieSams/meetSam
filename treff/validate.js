var regExEmail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

function validateLogin() {
    var form = document.getElementById("loginForm");
    
    if (form.name.value == "") {
        window.alert ("Enter Email");
        return false;
    }
    if (form.pass.value == "") {
        window.alert ("Enter Password");
        return false;
    }

    form.pass = CryptoJS.SHA256(form.name + form.pass);

    return true;
}

function validateRegistration() {
    var form = document.getElementById("registrationForm");
    var checkEmail = regExEmail.test(form.name.value)
	var passDig = /[0-9]/.test(form.pass1.value);
	var passLen = /^[A-Za-z0-9_]{6,10}$/.test(form.pass1.value);

    if (form.name.value == "" || form.pass1.value == "" || form.street.value == "" || form.city.value == "" ) {
        window.alert ("Incomplete Registration");
        return false;
    }

	if (form.zip.value == "" || form.state.value == "") {
        window.alert ("Incomplete Registration");
        return false;
    }

    if (checkEmail != true) {
        window.alert ("Invalid Email");
        return false;
    }

	 if (passDig != true || passLen != true) {
        window.alert ("Invalid Password");
        return false;
    }
	
	if (form.pass1.value != form.pass1.value){
		window.alert ("Passwords do not match");
		return false;
	}

    form.pass1 = CryptoJS.SHA256(form.name + form.pass1);
    form.pass2 = CryptoJS.SHA256(form.name + form.pass2);

	return true;
}

function validateTreff () {
    var form = document.getElementById("treffForm");
    var checkEmail1 = regExEmail.test(form.userName.value)
	var checkEmail2 = regExEmail.test(form.treffMate.value)

    if (form.userName.value == "" || form.treffMate.value == "" || form.street.value == "" || form.city.value == "" ) {
        window.alert ("Incomplete Treff");
        return false;
    }

	if (form.zip.value == "" || form.state.value == "") {
        window.alert ("Incomplete Treff");
        return false;
    }

    if (checkEmail1 != true || checkEmail1 != true) {
        window.alert ("Invalid Email");
        return false;
    }

	 

	return true;
}
