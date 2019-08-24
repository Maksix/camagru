<div class="w3-row w3-container w3-light-grey">
    <h2 class="w3-center">Reset</h2>

    <div id="updated" style="display: none;">
        <div class="w3-round-large w3-container w3-panel w3-yellow">
            <p class="w3-center">Password has been updated!</p>
        </div>
        <br>
    </div>

    <form id="form" action="/camagru/account/reset" method="post">
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" id="password" type="password" name="password"
                   placeholder="New password" required>
        </div>
        <br><br><br>
        <div id="invalidPasswordDiv" style="display: none;">
            <div class="w3-round-large w3-container w3-panel w3-yellow">
                <p class="w3-center" id="invalidPassword"></p>
            </div>
            <br>
        </div>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" id="password2" type="password" name="password2"
                   placeholder="Repeat new password" required>
        </div>

        <br><br><br>
        <div id="passwordErrorDiv" style="display: none;">
            <div class="w3-round-large w3-container w3-panel w3-yellow">
                <p class="w3-center" id="passwordError"></p>
            </div>
            <br>
        </div>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <div class="w3-container w3-quarter"></div>
            <button style="width: 50%"
                    class="w3-center w3-btn w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge"
                    type="submit"> Change password <i class='fas fa-key' style='font-size:18px'></i></button>
        </div>
        <br><br><br>
    </form>
</div>
<script src="/camagru/application/views/js/reset.js"></script>