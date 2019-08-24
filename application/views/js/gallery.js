(function () {
    const galleryForm = document.getElementById("gallery_form");

    function handleSubmit(evt) {
        var path = evt.target.dataset.imgPath;
        var name = evt.target.name;
        if (!name) {
            name = getName(evt.target.id);
        }
        if (name !== undefined && path !== undefined && name && path && name !== null) {
            var body = 'name=' + name + '&path=' + path;
            if (name === 'comment') {
                var comment = document.getElementById("Comment" + path).value;
                comment = escapeHtmll(comment);
                if (comment.length < 1) {
                    return;
                }
                if (comment.length > 100) {
                    var error = document.getElementById("symbolsError" + path);
                    error.style.display = "";
                    return;
                }
                body += '&comment=' + comment;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var response = JSON.parse(this.responseText);
                    if (response === "Deleted") {
                        window.location.href = document.location.href;
                    } else if (response === 'commented') {
                        var textarea = document.getElementById("Comment" + path);
                        textarea.value = "";
                        hideErrors(path);
                        if ((document.getElementById("showComments" + path).children[0].id === "showCommentsImage")) {
                            showComments(path);
                        } else {
                            deleteElementsFromDiv(path, 0);
                            showComments(path);
                        }
                    } else if (response['path'] !== undefined && response['path'] !== null) {
                        var likedPhoto = document.getElementById(response['path']);
                        likePhoto(likedPhoto, response['likes']);
                    } else if (response[0] !== undefined && response[0] !== null) {
                        for (var i = 0; i < response.length; i++) {
                            dealShowButton(document.getElementById("showComments" + path), i, path, response);
                        }
                    }
                }
            }
            xmlhttp.open("POST", document.location.href, true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(body);
        }
    }

    galleryForm.addEventListener('click', handleSubmit);
})();

function addElementsToDiv(userLogin, userComment, userDate, button, path) {
    var commentDiv = document.getElementById("commentDiv" + path);
    var div = document.createElement('div');
    var a = document.createElement('a');
    a.setAttribute("href", "/camagru/gallery/" + userLogin);
    div.setAttribute("id", "div" + path);
    var comment = document.createElement('p');
    var login = document.createElement('p');
    var date = document.createElement('p');
    var textLogin = document.createTextNode(userLogin);
    var textComment = document.createTextNode(userComment);
    var textDate = document.createTextNode(userDate);
    var leftDiv = document.createElement("div");
    var p = document.createElement("p");
    leftDiv.setAttribute("class", "w3-col w3-mobile");
    leftDiv.setAttribute("style", "width: 20%");
    leftDiv.appendChild(p);
    login.appendChild(textLogin);
    login.setAttribute("style", "color: #071C71; text-decoration: underline");
    date.appendChild(textDate);
    comment.appendChild(textComment);
    a.appendChild(login);
    div.appendChild(leftDiv);
    div.appendChild(a);
    div.appendChild(leftDiv.cloneNode(true));
    div.appendChild(comment);
    div.appendChild(leftDiv.cloneNode(true));
    div.appendChild(date);
    div.setAttribute("class", "w3-border-bottom");
    commentDiv.insertBefore(div, commentDiv.firstChild);
}

function deleteElementsFromDiv(path, flag) {
    if (flag === 1) {
        var div = document.getElementById("div" + path);
        if (div !== null) {
            div.remove();
        }
    } else {
        var div = document.getElementById("commentDiv" + path);
        if (div !== null) {
            div.innerHTML = "";
            changeImage(document.getElementById("showComments" + path).children[0]);
        }
    }
}

function likePhoto(button, likes) {
    var heart = button.children[0];
    if (heart.id === "likedImage") {
        heart.id = "nonLikedImage";
        heart.setAttribute("style", "font-size: 22px; margin-top: 14px;");
        heart.setAttribute("class", "far fa-heart");
        heart.innerHTML = " " + likes;
    } else if (heart.id === "nonLikedImage") {
        heart.id = "likedImage";
        heart.setAttribute("style", "font-size: 22px; margin-top: 14px; color: #FF7373");
        heart.setAttribute("class", "fas fa-heart");
        heart.innerHTML = " " + likes;
    }
}

function dealShowButton(button, i, path, response) {
    var image = button.children[0];
    if (image.id === "showCommentsImage") {
        addElementsToDiv(response[i]['user_login'], response[i]['comment_text'], response[i]['date'], button, path);
    } else {
        deleteElementsFromDiv(path, 1);
    }
    if (i === response.length - 1) {
        changeImage(image);
    }
}

function changeImage(image) {
    if (image.id === "showCommentsImage") {
        image.id = "hideCommentsImage";
        image.setAttribute("class", "fas fa-comment-slash");
    } else if (image.id === "hideCommentsImage") {
        image.id = "showCommentsImage";
        image.setAttribute("class", "fas fa-comment");
    }
}

function showComments(path) {
    var button = document.getElementById("showComments" + path);
    button.click();
}

function hideErrors(path) {
    if (document.getElementById("symbolsError" + path).style.display === "") {
        document.getElementById("symbolsError" + path).style.display = "none";
    }
}

function getName(id) {
    if (id === "likedImage" || id === "nonLikedImage") {
        return 'like';
    }
    if (id === "leaveCommentsImage") {
        return 'comment';
    }
    if (id === "deleteImage") {
        return 'delete';
    }
    if (id === "showCommentsImage" || id === "hideCommentsImage") {
        return 'show';
    }
    return null;
}

function escapeHtmll(text) {
    return text
        .replace(/&/g, "?amp;")
        .replace(/</g, "?lt;")
        .replace(/>/g, "?gt;")
        .replace(/"/g, "?quot;")
        .replace(/'/g, "?#039;");
}
