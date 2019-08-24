<div class="w3-row w3-container w3-light-grey" id="gallery_form">
    <h2 class="w3-center"><?php echo $login; ?>'s gallery</h2>
    <?php
    if (isset($paths) && isset($likes) && isset($date) && $paths && $likes && $date):
        foreach ($paths as $index => $path):?>
            <div class="w3-mobile w3-container w3-center">
                <br><br>
                <div class="w3-half w3-container"><p></p></div>
                <p>Posted on <?php echo $date[$index]['date'] ?></p>
                <img class="w3-image w3-mobile w3-round" style="width: 75%;" src="<?php echo $path['path'] ?>" alt="">
            </div>
            <div class="w3-col w3-mobile" style="width:13.5%"><p></p></div>
            <div class="w3-col w3-mobile" style="width:5%">
                <button class="w3-mobile w3-button w3-round-xlarge w3-tiny w3-hover-light-grey" name="like"
                        style="padding: 1px"
                        data-img-path="<?php echo $path['path'] ?>" id="<?php echo $path['path'] ?>">
                    <?php if ($isliked[$index]) : ?>
                        <i id="likedImage" style="font-size: 22px; margin-top: 14px; color: #FF7373"
                           data-img-path="<?php echo $path['path'] ?>" class='fas fa-heart'>
                            <?php echo $likes[$index]['likes']; ?></i>
                    <?php endif;
                    if (!$isliked[$index]) : ?>
                        <i id="nonLikedImage" style="font-size: 22px; margin-top: 14px"
                           data-img-path="<?php echo $path['path'] ?>" class='far fa-heart'>
                            <?php echo $likes[$index]['likes']; ?></i>
                    <?php endif; ?>
                </button>
            </div>
            <?php if (isset($_SESSION['profile']) && ($_SESSION['profile'] === '1' || $_SESSION['profile'] === '2')): ?>
                <div class="w3-half w3-container">
                <textarea class="w3-mobile w3-input w3-border-0 w3-round-large" placeholder="Comment a photo..."
                          style="margin-top: 8px;resize: none;" id="Comment<?php echo $path['path'] ?>"
                          cols="30" rows="1"></textarea>
                </div>
                <button class="w3-mobile w3-button w3-round-xlarge w3-tiny w3-hover-light-grey" style="padding: 1px"
                        name="comment" id="leaveComment<?php echo $path['path'] ?>"
                        data-img-path="<?php echo $path['path'] ?>">
                    <i data-img-path="<?php echo $path['path'] ?>"
                       id="leaveCommentsImage" class='fas fa-arrow-circle-right'
                       style='font-size:24px; margin-top:15px'></i>
                </button>
                <button class="w3-mobile w3-button w3-round-xlarge w3-tiny w3-hover-light-grey" style="padding: 1px"
                        id="showComments<?php echo $path['path'] ?>" name="show"
                        data-img-path="<?php echo $path['path'] ?>">
                    <i data-img-path="<?php echo $path['path'] ?>"
                       id="showCommentsImage" class='fas fa-comment'
                       style='font-size:24px; margin-top:14px'></i>
                </button>
                <?php
                if ($login === "Your") : ?>
                    <button class="w3-mobile w3-button w3-round-xlarge w3-tiny w3-hover-light-grey" style="padding: 1px"
                            name="delete"
                            data-img-path="<?php echo $path['path'] ?>" id="<?php echo $path['path'] ?>">
                        <i data-img-path="<?php echo $path['path'] ?>"
                           id="deleteImage" class='fas fa-trash-alt' style='font-size:24px; margin-top: 12px'></i>
                    </button>
                <?php endif; ?>
                <br>
                <div id="symbolsError<?php echo $path['path'] ?>" class="w3-round-large w3-container w3-panel w3-yellow"
                     style="display: none;">
                    <p class="w3-center">Your comment is more than 100 symbols</p>
                </div>
                <br>
                <div class="w3-container" id="commentDiv<?php echo $path['path'] ?>">
                </div>
            <?php endif; ?>
        <?php endforeach;
    endif; ?>
</div>

<script src="/camagru/application/views/js/gallery.js">
</script>
