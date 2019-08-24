<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="57x57" href="/camagru/application/views/icons/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/camagru/application/views/icons/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/camagru/application/views/icons/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/camagru/application/views/icons/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114"
          href="/camagru/application/views/icons/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120"
          href="/camagru/application/views/icons/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144"
          href="/camagru/application/views/icons/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152"
          href="/camagru/application/views/icons/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180"
          href="/camagru/application/views/icons/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
          href="/camagru/application/views/icons/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/camagru/application/views/icons/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/camagru/application/views/icons/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/camagru/application/views/icons/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css'
          integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
</head>
<style>
    #inputSearch, button:focus, input:focus {
        outline: none;
    }

    a {
        text-decoration: none;
    }

    input[type='file']{
    }
</style>
<body>
<div class="w3-bar" style="background-color: #FFFE73; overflow: auto;">
    <a class="w3-bar-item w3-button w3-mobile w3-hover-yellow" href="/camagru/">Camagru</a>
    <?php if (!isset($_SESSION['authorized']['id'])) : ?>
        <a class="w3-bar-item w3-button w3-mobile w3-hover-yellow" href="/camagru/account/login">Log in</a>
        <a class="w3-bar-item w3-button w3-mobile w3-hover-yellow" href="/camagru/account/register">Register</a>
        <a class="w3-bar-item w3-button w3-mobile w3-hover-yellow" href="/camagru/account/recovery">Recovery</a>
    <?php endif;
    if (isset($_SESSION['authorized']['id'])) : ?>
        <a class="w3-bar-item w3-button w3-mobile w3-hover-yellow" href="/camagru/account/edit">Edit profile</a>
        <a class="w3-bar-item w3-button w3-mobile w3-hover-yellow" href="/camagru/photo">Take a photo</a>
        <a class="w3-bar-item w3-button w3-mobile w3-hover-yellow" id="galleryHref"
           href="/camagru/gallery/<?php echo $_SESSION['login'] ?>">My gallery</a>
    <?php endif; ?>
    <span id="showSearch" class="w3-bar-item w3-button w3-mobile w3-hover-yellow"><i class='fab fa-sistrix' style='font-size:24px'></i></span>
    <?php if (isset($_SESSION['authorized']['id'])) : ?>
        <a class="w3-bar-item w3-button w3-mobile w3-hover-yellow" href="/camagru/account/logout" style="float: right"><i class='fas fa-sign-out-alt' style='font-size:24px'></i></a>
    <?php endif; ?>
</div>
<input id="inputSearch" class="w3-bar-item w3-input w3-mobile" style="background-color: #FFFE73; display: none"
       type="text" autocomplete="off" id="inputText"
       placeholder="Search...">
<div class="w3-bar-item w3-mobile" id="searchField"></div>
<?php echo $content; ?>
</body>
<script src="/camagru/application/views/js/search.js">
</script>
</html>