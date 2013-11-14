function validate () {
    var form = document.getElementById("logInForm");
    
    if (form.name.value == "") {
        window.alert ("Enter name");
        return false;
    }
    if (form.comments.value == "") {
        window.alert ("Enter Password");
        return false;
    }

    return true;
}
