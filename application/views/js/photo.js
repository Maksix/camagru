var video = document.getElementById('video');

if (video !== null && navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({video: true}).then(function (stream) {
        video.srcObject = stream;
        video.play();
    });
} else if (video !== null && navigator.getUserMedia) { // Standard
    navigator.getUserMedia({video: true}, function (stream) {
        video.src = stream;
        video.play();
    }, errBack);

} else if (video !== null && navigator.webkitGetUserMedia) { // WebKit-prefixed
    navigator.webkitGetUserMedia({video: true}, function (stream) {
        video.src = window.webkitURL.createObjectURL(stream);
        video.play();
    }, errBack);

} else if (video !== null && navigator.mozGetUserMedia) { // Mozilla-prefixed
    navigator.mozGetUserMedia({video: true}, function (stream) {
        video.srcObject = stream;
        video.play();
    }, errBack);
}

if (video !== null) {
    var canvas = document.createElement("canvas");
    canvas.width = 960;
    canvas.height = 720;
    var context = canvas.getContext('2d');
    var video = document.getElementById('video');

    document.getElementById("pixel").addEventListener("click", function () {
        document.getElementById("pixelNmb").style.display = "inline";
    });

    document.getElementById("snap").addEventListener("click", function () {
        context.drawImage(video, 0, 0, 960, 720);
    });
}

function showCameraMenu() {
    if (document.getElementById("UploadDiv").style.display !== "none") {
        document.getElementById("UploadDiv").style.display = "none";
    }
    document.getElementById("cameraDiv").style.display = "inline";
}

function showUploadMenu() {
    if (document.getElementById("cameraDiv").style.display !== "none") {
        document.getElementById("cameraDiv").style.display = "none";
    }
    document.getElementById("UploadDiv").style.display = "inline";
}

function hidePixel() {
    if (!document.getElementById("pixelNmb").hasAttribute("hidden")) {
        document.getElementById("pixelNmb").style.display = "none";
    }
}

function hidePixelUpload() {
    if (!document.getElementById("pixelNmbUpload").hasAttribute("hidden")) {
        document.getElementById("pixelNmbUpload").style.display = "none";
    }
}

document.getElementById("pixelUpload").addEventListener("click", function () {
    document.getElementById("pixelNmbUpload").style.display = "inline";
});

// AJAX Camera
if (document.getElementById("snap") !== null) {
    document.getElementById("snap").onclick = function (evt) {
        evt.preventDefault();
        var image = canvas.toDataURL('image/png, 1.0');
        var filter = getChecked("filter");
        var sticker = getChecked("sticker");
        var pixel = document.getElementById("pixelNmb").value;
        var body = 'filter=' + filter + '&sticker=' + sticker + '&pixel=' + pixel + '&image=' + image;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var path = JSON.parse(this.responseText);
                if (path === "sizeError") {
                    document.getElementById("sizeError").style.display = "inline";
                }
                var img = document.getElementById("snap-image");
                img.setAttribute("src", path);
                img.removeAttribute("hidden");
                document.getElementById("save").style.display = "";
                if (document.getElementById("success").style.display !== "none")
                    document.getElementById("success").style.display = "none"
            }
        };
        xmlhttp.open("POST", "/camagru/photo", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(body);
    }
}

if (document.getElementById("save") !== null) {
    document.getElementById("save").onclick = function (evt) {
        evt.preventDefault();
        var body = 'save=1';
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var path = JSON.parse(this.responseText);
                document.getElementById("save").style.display = "none";
                document.getElementById("success").style.display = "";
                updateSideBar(path, "photos");
            }
        };
        xmlhttp.open("POST", "/camagru/photo", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(body);
    }
}

if (document.getElementById("saveUploaded") !== null) {
    document.getElementById("saveUploaded").onclick = function (evt) {
        evt.preventDefault();
        var body = 'save=1';
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var path = JSON.parse(this.responseText);
                document.getElementById("saveUploaded").style.display = "none";
                document.getElementById("successUploaded").style.display = "";
                updateSideBar(path, "uploadedPhotos");
            }
        };
        xmlhttp.open("POST", "/camagru/photo", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(body);
    }
}

function updateSideBar(path, id) {
    var div = document.getElementById(id);
    var newImageDiv = document.createElement("div");
    var br = document.createElement("br");
    if (div.childElementCount >= 6) {
        div.removeChild(div.lastChild);
        div.removeChild(div.lastChild);
    }
    var img = document.createElement("img");
    img.setAttribute("src", path);
    img.setAttribute("class", "w3-mobile");
    img.setAttribute("style", "align-content: center; width: 90%;");
    newImageDiv.appendChild(img);
    newImageDiv.appendChild(br);
    newImageDiv.appendChild(br.cloneNode());
    newImageDiv.appendChild(br.cloneNode());
    div.insertBefore(newImageDiv, div.children[1]);
}

function getChecked(radio) {
    var name = document.getElementsByName(radio);
    for (var i = 0; i < name.length; i++) {
        if (name[i].type === "radio" && name[i].checked) {
            return name[i].value;
        }
    }
}

// AJAX Upload

if (document.getElementById("upload") !== null) {
    upload = document.getElementById("upload");
    upload.onclick = function (evt) {
        evt.preventDefault();
        error = document.getElementById("errorUpload");
        if (error.style.display !== 'none') {
            error.style.display = "none";
        }
        var fileInput = document.getElementById("file");
        var file = fileInput.files[0];
        if (file !== undefined) {
            var formData = new FormData();
            formData.append('file', file);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "/camagru/photo", true);
            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    response = JSON.parse(this.responseText);
                    if (response.substr(0, 5) !== '/data') {
                        error.style.display = "";
                    } else {
                        imageDiv = document.getElementById("imageDiv");
                        imageDiv.style.display = "inline";
                        document.getElementById("uploaded-image").setAttribute("src", response);
                    }
                }
            };
            xmlhttp.send(formData);
        }
    }
}

// AJAX Apply filter upload

if (document.getElementById("apply") !== null) {
    apply = document.getElementById("apply");
    apply.onclick = function (evt) {
        evt.preventDefault();
        var filter = getChecked("filterUpload");
        var sticker = getChecked("stickerUpload");
        var pixel = document.getElementById("pixelNmbUpload").value;
        var body = 'filter=' + filter + '&sticker=' + sticker + '&pixel=' + pixel + '&apply=';
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var response = JSON.parse(this.responseText);
                var filterImage = document.getElementById("filterImage");
                filterImage.setAttribute("src", response);
                filterImage.style.display = "inline";
                var saveButton = document.getElementById("saveUploaded");
                saveButton.style.display = "inline";
                document.getElementById("successUploaded").style.display = "none";
            }
        };
        xmlhttp.open("POST", "/camagru/photo", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(body);
    }
}

