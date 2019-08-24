<div class="w3-row w3-container w3-light-grey">
    <h2 class="w3-center">Login</h2>
    <div class="w3-container w3-quarter"></div>
    <div class=" w3-container w3-half">
        <input class="w3-center w3-input w3-border-0 w3-round-large" type="text" id="email" name="email"
               placeholder="Email or Login" required>
    </div>
    <br><br><br>
    <div class="w3-container w3-quarter"></div>
    <div class=" w3-container w3-half">
        <input class="w3-center w3-input w3-border-0 w3-round-large" id="password" type="password" name="password"
               placeholder="Password"
               required>
    </div>
    <br><br>
    <p class="w3-center" id="forgotTip"><a href="/camagru/account/recovery">Forgot your password?</a></p>
    <div class="w3-container w3-quarter"></div>
    <div class=" w3-container w3-half">
        <div class="w3-container w3-quarter"></div>
        <button class="w3-center w3-button w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge"
                style="width: 50%" type="submit" id="submit">Log in
        </button>
    </div>
    <br><br><br>
    <div id="errorDiv" class="w3-container w3-panel w3-yellow" style="display: none;">
        <p class="w3-center" id="error"></p>
    </div>
</div>
<script src="/camagru/application/views/js/login.js">
</script>