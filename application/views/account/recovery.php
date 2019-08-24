<div class="w3-row w3-container w3-light-grey">
    <h2 class="w3-center">Recovery</h2>
    <div id="registeredDiv" class="w3-container w3-panel w3-yellow" style="display: none;">
        <p class="w3-center" id="registered" >Please follow the link in message we sent to your email to confirm your
            account</p>
    </div>
    <form id="form" action="/camagru/account/recovery" method="post">
        <p class="w3-center">Please enter your email</p>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" type="text" id="email" name="email"  placeholder="Your email" required>
        </div>
        <br>
        <br><br>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <div class="w3-container w3-quarter"></div>
        <button style="width: 50%" class="w3-center w3-btn w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge" type="submit">OK</button>
        </div>
            <br><br><br>
        <div id="errorDiv" class="w3-container w3-panel w3-yellow" style="display: none">
            <p class="w3-center" id="error"></p>
        </div>
    </form>
</div>
<script src="/camagru/application/views/js/recovery.js">
</script>