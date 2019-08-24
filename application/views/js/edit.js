function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

document.getElementById('form1').onsubmit = function (evt) {
    evt.preventDefault();
    var password = escapeHtml(document.getElementById("password").value);
    var body = '&password=' + password;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText !== 'Success') {
                var string = JSON.parse(this.responseText);
                if (string['passwordError'] !== undefined) {
                    document.getElementById('passwordError').innerHTML = string['passwordError'];
                    document.getElementById('errorDiv').style.display = "";
                }
            } else {
                document.getElementById("form1").style.display = "none";
                document.getElementById("emailForm").style.display = "inline";
                document.getElementById("loginForm").style.display = "inline";
                document.getElementById("passwordForm").style.display = "inline";
                document.getElementById("notificationForm").style.display = "inline";
            }
        }
    };
    xmlhttp.open("POST", "/camagru/account/edit/", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(body);
};

document.getElementById('notificationForm').onsubmit = function (evt) {
    evt.preventDefault();
    var body = 'Notifications=1';
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var string = JSON.parse(this.responseText);
            document.getElementById("notifications").innerHTML = string['Notifications'];
            document.getElementById("notificationsDiv").style.display = "";
        }
    };
    xmlhttp.open("POST", "/camagru/account/edit/", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(body);
};

document.getElementById('loginForm').onsubmit = function (evt) {
    evt.preventDefault();
    var login = escapeHtml(document.getElementById("login").value);
    var body = '&login=' + login;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var string = JSON.parse(this.responseText);
            var div = document.getElementById("loginErrorDiv");
            if (string['login'] !== undefined && string['login'] === "Login has been successfully updated") {
                document.getElementById('loginError').innerHTML = string['login'];
                document.getElementById('loginButton').style.display = "none";
                document.getElementById('galleryHref').setAttribute("href", "/camagru/gallery/" + login);
                div.style.display = "";
            } else {
                document.getElementById('loginError').innerHTML = string['login'];
                div.style.display = "";
            }
        }
    };
    xmlhttp.open("POST", "/camagru/account/edit/", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(body);
};

document.getElementById('passwordForm').onsubmit = function (evt) {
    evt.preventDefault(evt);
    var password = escapeHtml(document.getElementById("newPassword").value);
    var body = '&newPassword=' + password;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var string = JSON.parse(this.responseText);
            var div = document.getElementById("newPasswordErrorDiv");
            if (string['password'] !== undefined && string['password'] === "Password successfully changed") {
                document.getElementById('newPasswordError').innerHTML = string['password'];
                document.getElementById('passwordButton').style.display = "none";
                div.style.display = "";
            } else {
                document.getElementById('newPasswordError').innerHTML = string['password'];
                div.style.display = "";
            }
        }
    }
    xmlhttp.open("POST", "/camagru/account/edit/", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(body);
};

document.getElementById('emailForm').onsubmit = function (evt) {
    evt.preventDefault(evt);
    var email = escapeHtml(document.getElementById("email").value);
    var body = '&email=' + email;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var string = JSON.parse(this.responseText);
            var error = document.getElementById("emailError");
            if (string['email'] === 'Success') {
                window.location.href = "/camagru/";
            } else if (string['email'] === "Wrong email") {
                error.innerHTML = string['email'];
                document.getElementById("emailErrorDiv").style.display = "";
            } else {
                error.innerHTML = string;
                document.getElementById("emailErrorDiv").style.display = "";
            }
        }
    }
    xmlhttp.open("POST", "/camagru/account/edit/", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(body);
};
