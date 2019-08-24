<div class="w3-row w3-container w3-light-grey">
    <h2 class="w3-center">Take a photo!</h2>

<!--    Menu field-->

    <br><br>
    <button id="showCameraButton" style="width: 13%" onclick="showCameraMenu()"
            class="w3-button w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge">
        Camera <i class="fa fa-camera"></i>
    </button>
    <button id="showUploadButton" style="width: 13%" onclick="showUploadMenu()"
            class="w3-button w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge">
        Upload image <i style="font-size: 16px" class="fa fa-download"></i>
    </button>
    <br>
    <br><br>

    <!--Camera field-->

    <div  id="cameraDiv" style="display: none;">
        <div class="w3-col w3-mobile w3-half">
        <video id="video" width="100%" autoplay></video>
        <br><br>
        <br>
        <p id="sizeError" style="display: none"> Size of image is more than 5Mb</p>
        <p>Choose your filter</p>
        <label><input type="radio" onclick="hidePixel()" name="filter" value="noFilter" checked> No filter</label><br>
        <label><input type="radio" onclick="hidePixel()" name="filter" value="Negative"> Negative</label><br>
        <label><input type="radio" onclick="hidePixel()" name="filter" value="GrayScale"> Gray</label><br>
        <label><input type="radio" onclick="hidePixel()" name="filter" value="Emboss"> Emboss</label><br>
        <label><input type="radio" onclick="hidePixel()" name="filter" id="pixel" value="Pixel"> Pixel</label><br>
        <p><input type="number" style="display: none" name="pixel" id="pixelNmb" value="1" min="1" max="30" step="1">
        </p>
        <p>Choose a sticker</p>
        <input type="text" hidden name="image" id="image" value="">
        <label>
            <input type="radio" name="sticker" value="noSticker" checked> No sticker
        </label><br><br>
        <label>
            <input type="radio" name="sticker" id="dog" value="dog">
            <img style="align-content: center; width: 25%;" src="/camagru/application/views/images/dog.png">
        </label>
        <label>
            <input type="radio" name="sticker" id="cat" value="cat">
            <img style="align-content: center; width: 25%;" src="/camagru/application/views/images/cat.png">
        </label>
        <label>
            <input type="radio" name="sticker" id="Hm" value="Hm">
            <img style="align-content: center; width: 25%;" src="/camagru/application/views/images/Hm.png">
        </label>
            <br><br>
            <div class="w3-col" style="width: 36%"><p></p></div>
            <button type="submit" id="snap" id="showCameraButton" style="width: 24%"
                    class="w3-button w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge">
                Snap Photo
            </button>
        <br><br><br>
        <img hidden src="" id="snap-image" width="100%">
        <br>
        <br>
        <div class="w3-col" style="width: 36%"><p></p></div>
        <button type="button" id="save" style="width: 25%; display:none;"
                class="w3-button w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge">
            Save image
        </button>
        <div id="success" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
            <p class="w3-center">Image successfully saved!</p>
        </div>
        <br><br>
        </div>
        <div class="w3-col" style="width: 25%"><p></p></div>
        <div class="w3-col w3-quarter " id="photos">
            <h4 class="w3-center">Your previous photos:</h4>
            <?php
            if (isset($paths) && $paths):
                foreach ($paths as $index => $path): ?>
                <div>
                    <img class="w3-mobile" style="align-content: center; width: 90%;" src="<?php echo $path['path'] ?>">
                    <br><br><br>
                </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>




    <!--Upload field-->

    <div  id="UploadDiv" style="display: none;">
        <div class="w3-col w3-mobile w3-half">
        <br><br>
        <input type="file" name="userfile" id="file">

        <button type="button" id="upload" name="upload" style="width: 25%;"
                class="w3-button w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge">
            Upload
        </button>
        <br><br>
        <div id="errorUpload" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
            <p class="w3-center">Image size can't be more than 5Mb and less than 25Kb</p>
        </div>
        <div class="w3-col w3-mobile" id="imageDiv" style="display: none; width: 100%" >
            <img src="" style="width: 100%;" id="uploaded-image">
            <p>Choose your filter</p>
            <label><input type="radio" onclick="hidePixelUpload()" name="filterUpload" value="noFilter" id="noFilter" checked> No filter</label><br>
            <label><input type="radio" onclick="hidePixelUpload()" name="filterUpload" value="Negative"> Negative</label><br>
            <label><input type="radio" onclick="hidePixelUpload()" name="filterUpload" value="GrayScale"> Gray</label><br>
            <label><input type="radio" onclick="hidePixelUpload()" name="filterUpload" value="Emboss"> Emboss</label><br>
            <label><input type="radio" onclick="hidePixelUpload()" name="filterUpload" id="pixelUpload" value="Pixel"> Pixel</label><br>
            <p><input type="number" style="display: none" name="pixel" id="pixelNmbUpload" value="1" min="1" max="30"
                      step="1"></p>
            <p>Choose a sticker</p>
            <input type="text" hidden name="image" id="image" value="">
            <label><input type="radio" name="stickerUpload" value="noSticker" checked> No sticker</label><br><br>
            <label>
                <input type="radio" name="stickerUpload" id="dog" value="dog">
                <img style="align-content: center; width: 25%;" src="/camagru/application/views/images/dog.png">
            </label>
            <label>
                <input type="radio" name="stickerUpload" id="cat" value="cat">
                <img style="align-content: center; width: 25%;" src="/camagru/application/views/images/cat.png">
            </label>
            <label>
                <input type="radio" name="stickerUpload" id="Hm" value="Hm">
                <img style="align-content: center; width: 25%;" src="/camagru/application/views/images/Hm.png">
            </label>
            <br><br><br>
            <div class="w3-col" style="width: 36%"><p></p></div>
            <button type="button" id="apply" name="upload" style="width: 25%;"
                    class="w3-button w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge">
                Apply
            </button>
            <br><br><br>
            <img style="display:none; width: 100%;" src="" id="filterImage"><br><br><br>
            <div class="w3-col" style="width: 36%"><p></p></div>
            <button type="button" id="saveUploaded" style="width: 25%; display:none;"
                    class="w3-button w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge">
                Save image
            </button>
            <div id="successUploaded" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
                <p class="w3-center">Image successfully saved!</p>
            </div>
            <br><br>
        </div>
        </div>
        <div class="w3-col" style="width: 25%"><p></p></div>
        <div class="w3-col w3-quarter " id="uploadedPhotos">
            <h4 class="w3-center">Your previous photos:</h4>
            <?php
            if (isset($paths) && $paths):
                foreach ($paths as $index => $path): ?>
                    <div>
                        <img class="w3-mobile" style="align-content: center; width: 90%;" src="<?php echo $path['path'] ?>">
                        <br><br><br>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>

</div>
<script src="/camagru/application/views/js/photo.js">
</script>
