document.getElementById("logInForm").onsubmit = validate;
  function validate ()
  {
    var elt = document.getElementById("logInForm");
    if (elt.name.value == "")
    {
      window.alert ("Enter name");
      return false;
    }
    if (elt.comments.value == "")
    {
      window.alert ("Enter Password");
      return false;
    }
    return true;
  }
