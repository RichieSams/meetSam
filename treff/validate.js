document.getElementById("loginForm").onsubmit = validateLogin;
function validateLogin () {
    var form = document.getElementById("loginForm");
    
    if (form.name.value == "") {
        window.alert ("Enter Email");
        return false;
    }
    if (form.pass.value == "") {
        window.alert ("Enter Password");
        return false;
    }

    return true;
}

var regExEmail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
document.getElementById("registrationForm").onsubmit = validateRegistation;
function validateLogin () {
    var form = document.getElementById("registrationForm");
    var checkEmail = regExEmail.test(form.name.value)
	var passDig = /[0-9]/.test(form.pass1.value);
	var passLen = /^[A-Za-z0-9_]{6,10}$/.test(form.pass1.value);

    if (form.name.value == "" && ) {
        window.alert ("Enter name");
        return false;
    }
    if (form.pass.value == "") {
        window.alert ("Enter Password");
        return false;
    }

    return true;
}