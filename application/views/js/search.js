function escapeHtml(text) {
    return text
        .replace(/&/g, "?amp;")
        .replace(/</g, "?lt;")
        .replace(/>/g, "?gt;")
        .replace(/"/g, "?quot;")
        .replace(/'/g, "?#039;");
}

document.getElementById("inputSearch").onkeyup = function (evt) {
    var input = escapeHtml(this.value);
    console.log(input);
    if (input.length > 0) {
        evt.preventDefault();
        var body = 'search=' + input;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var arr = (JSON.parse(this.responseText));
                console.log(arr);
                var div = document.getElementById("searchField");
                removeElementsFromDiv(div);
                for (var i = 0; i < arr.length; i++) {
                    addElementsToDiv(arr[i]['login'], div);
                }
                div.style.display = "inline";
            }
        };
        xmlhttp.open("POST", "/camagru/", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(body);
    } else {
        removeElementsFromDiv(document.getElementById("searchField"));
    }

    function addElementsToDiv(login, div) {
        var a = document.createElement("a");
        a.setAttribute("href", "/camagru/gallery/" + login);
        var p = document.createElement("p");
        var text = document.createTextNode(login);
        p.appendChild(text);
        p.setAttribute("style", "text-decoration: underline; color: #071C71");
        a.appendChild(p);
        a.setAttribute("class", "w3-mobile");
        div.appendChild(a);
        div.setAttribute("style", "background-color: #FFFE73;");
    }

    function removeElementsFromDiv(div) {
        while (div.firstChild) {
            div.removeChild(div.firstChild);
        }
    }
}

document.getElementById("showSearch").onclick = (function () {
    var input = document.getElementById("inputSearch");
    if (input.style.display === "none") {
        input.style.display = "inline";
        input.focus();
    } else {
        var div = document.getElementById("searchField");
        while (div.firstChild) {
            div.removeChild(div.firstChild);
        }
        input.value = "";
        input.style.display = "none";
    }
});