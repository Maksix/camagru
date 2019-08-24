<div class="w3-row w3-container w3-light-grey">
    <h2 class="w3-center">Edit</h2>
    <form id="form1">
        <p class="w3-center">Please enter your password to edit your profile</p>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" id="password" type="password" name="password"
                   placeholder="Password" required>
        </div>
        <br><br><br>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <div class="w3-container w3-quarter"></div>
            <button style="width: 50%"
                    class="w3-center w3-btn w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge"
                    type="submit"><i class="fas fa-unlock-alt" style="font-size: 24px"></i></button>
        </div>
        <br><br><br>
        <div id="errorDiv" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
            <p class="w3-center" id="passwordError"></p>
        </div>
        <br>
    </form>

    <form style="display: none" id="emailForm">
        <br><br>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" type="email" name="email" id="email"
                   placeholder="New Email" required>
        </div>
        <br><br><br><br>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <div class="w3-container w3-quarter"></div>
            <button style="width: 50%"
                    class="w3-center w3-btn w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge"
                    id="emailButton" type="submit">Change email
            </button>
        </div>
        <br><br>
        <div id="emailErrorDiv" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
            <p class="w3-center" id="emailError"></p>
        </div>
        <br><br>
    </form>

    <form style="display: none" id="loginForm">
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" type="text" name="login" id="login"
                   placeholder="New Login" required>
        </div>
        <br><br><br><br>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <div class="w3-container w3-quarter"></div>
            <button style="width: 50%"
                    class="w3-center w3-btn w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge"
                    id="loginButton" type="submit">Change login
            </button>
        </div>
        <br><br>
        <div id="loginErrorDiv" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
            <p class="w3-center" id="loginError"></p>
        </div>
        <br><br>
    </form>

    <form style="display: none" id="passwordForm">
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" type="password" id="newPassword"
                   name="newPassword" placeholder="New Password" required>
        </div>
        <br><br><br><br>
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <div class="w3-container w3-quarter"></div>
            <button style="width: 50%"
                    class="w3-center w3-btn w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge"
                    id="passwordButton" type="submit">Change password
            </button>
        </div>
        <br><br><br><br>
        <div id="newPasswordErrorDiv" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
            <p class="w3-center" id="newPasswordError"></p>
        </div>
    </form>

    <form style="display: none" id="notificationForm">
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <div class="w3-container w3-quarter"></div>
            <button style="width: 50%"
                    class="w3-center w3-btn w3-white w3-mobile w3-hover-pale-yellow w3-border w3-round-xlarge"
                    id="notificationButton" type="submit">Change notifications
            </button>
        </div>
        <br><br><br><br>
        <div id="notificationsDiv" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
            <p id="notifications" class="w3-center" id="newPasswordError"></p>
        </div>
        <br><br>
    </form>

</div>
<script src="/camagru/application/views/js/edit.js">
</script>