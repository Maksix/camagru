function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

document.getElementById('form').onsubmit = function(evt) {
    evt.preventDefault(evt);
    var email = escapeHtml(document.getElementById("email").value);
    var password = escapeHtml(document.getElementById("password").value);
    var password2 = escapeHtml(document.getElementById("password2").value);
    var login = escapeHtml(document.getElementById("login").value);
    var body = 'email=' + email + '&login=' + login + '&password=' + password + '&password2=' + password2 +'&submit';
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText !== 'Success') {
                var string = JSON.parse(this.responseText);

                if (string['invalidEmail'] !== undefined) {
                    document.getElementById('emailError').innerHTML = string['invalidEmail'];
                    document.getElementById("emailErrorDiv").style.display = "";
                }
                if (string['usedEmail'] !== undefined) {
                    document.getElementById('emailError').innerHTML = string['usedEmail'];
                    document.getElementById("emailErrorDiv").style.display = "";

                }
                if (string['invalidLogin'] !== undefined) {
                    document.getElementById('loginError').innerHTML = string['invalidLogin'];
                    document.getElementById("loginErrorDiv").style.display = "";

                }
                if (string['usedLogin'] !== undefined) {
                    document.getElementById('loginError').innerHTML = string['usedLogin'];
                    document.getElementById("loginErrorDiv").style.display = "";

                }
                if (string['invalidPassword'] !== undefined) {
                    document.getElementById('invalidPassword').innerHTML = string['invalidPassword'];
                    document.getElementById("invalidPasswordDiv").style.display = "";

                }
                if (string['matchPasswords'] !== undefined) {
                    document.getElementById('passwordError').innerHTML = string['matchPasswords'];
                    document.getElementById("passwordErrorDiv").style.display = "";

                }
            } else {
                document.getElementById("form").style.display = "none";
                document.getElementById("registeredDiv").style.display = "";
            }
        }
    };
    xmlhttp.open("POST", "/camagru/account/register", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(body);
};