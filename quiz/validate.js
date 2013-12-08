function validate () {
    var form = document.getElementById("logInForm");
    
    if (form.name.value == "") {
        alert("Enter name");
        return false;
    }
    if (form.comments.value == "") {
        alert("Enter Password");
        return false;
    }

    return true;
}
