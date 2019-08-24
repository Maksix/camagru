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
    var password = escapeHtml(document.getElementById("password").value);
    var password2 = escapeHtml(document.getElementById("password2").value);
    var body = 'password=' + password + '&password2=' + password2;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText !== 'Success') {
                string = JSON.parse(this.responseText);
                if (string['invalidPassword'] !== undefined) {
                    document.getElementById('invalidPassword').innerHTML = string['invalidPassword'];
                    document.getElementById('invalidPasswordDiv').style.display = "";
                }
                if (string['matchPasswords'] !== undefined) {
                    document.getElementById('passwordError').innerHTML = string['matchPasswords'];
                    document.getElementById('passwordErrorDiv').style.display = "";
                }
            } else {
                document.getElementById("form").style.display = "none";
                document.getElementById("updated").style.display = "inline";
            }
        }
    };
    xmlhttp.open("POST", "/camagru/account/reset/", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(body);
};