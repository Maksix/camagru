(function () {
    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    document.getElementById('submit').onclick = function () {
        var email = escapeHtml(document.getElementById("email").value);
        var password = escapeHtml(document.getElementById("password").value);
        var body = 'email=' + email + '&password=' + password + '&submit';
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                if (this.responseText === "Success") {
                    window.location.href = "/camagru/";
                } else {
                    document.getElementById("errorDiv").style.display = "";
                    document.getElementById('error').innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("POST", "/camagru/account/login", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(body);
    };
}());