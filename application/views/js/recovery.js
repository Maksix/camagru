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
    var body = 'email=' + email;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText !== 'Success') {
                string = JSON.parse(this.responseText);
                if (string['Email'] !== undefined) {
                    document.getElementById("errorDiv").style.display = "";
                    document.getElementById('error').innerHTML = string['Email'];
                }
            } else {
                document.getElementById("form").style.display = "none";
                document.getElementById("registeredDiv").style.display = "";
            }
        }
    };
    xmlhttp.open("POST", "/camagru/account/recovery/", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(body);
};