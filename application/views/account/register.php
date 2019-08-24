<div class="w3-row w3-container w3-light-grey">
    <h2 class="w3-center">Register</h2>
    <br>
    <div id="registeredDiv" class="w3-round-large w3-container w3-panel w3-yellow" style="display: none;">
        <p class="w3-center" id="registered">Please follow the link in message we sent to your email to confirm your
            account</p>
    </div>

    <form id="form">
        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" id="email" type="email" name="email"
                   placeholder="Email" required>
        </div>
        <br><br><br>
        <div id="emailErrorDiv" style="display: none;">
            <div class="w3-round-large w3-container w3-panel w3-yellow">
                <p class="w3-center" id="emailError"></p>
            </div>
            <br>
        </div>


        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" id="login" type="text" name="login"
                   placeholder="Login" required>
        </div>
        <br><br><br>
        <div id="loginErrorDiv" style="display: none;">
            <div id="loginErrorDiv" class="w3-round-large w3-container w3-panel w3-yellow">
                <p class="w3-center" id="loginError"></p>
            </div>
            <br>
        </div>


        <div class="w3-container w3-quarter"></div>
        <div class=" w3-container w3-half">
            <input class="w3-center w3-input w3-border-0 w3-round-large" id="password" type="password" name="password"
                   placeholder="Password" required>
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
                   placeholder="Repeat password" required>
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
                    id="passwordButton" type="submit"><i class="fa fa-lock" style="font-size:18px"></i> Create new
                account
            </button>
        </div>
        <br><br><br>
    </form>
</div>

<script src="/camagru/application/views/js/register.js"></script>