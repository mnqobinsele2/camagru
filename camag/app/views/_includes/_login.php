    <section id="banner">
        <div class="container">
            <h1>Welcome To<br>Camagru</h1>

        </div>
    </section>
    <div class="form_container">
        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert"><?=Session::get('error')?></div>
        <?php endif ?>
        <div class="login_switches">
            <div class="l_btn_0" id="l_btn_0" onclick="loginSwitch(this)">Sign In</div>
            <div class="l_btn_1" id="l_btn_1" onclick="loginSwitch(this)">Sign Up</div>
        </div>
        <form action="<?=URL?>login/signin" method="post" id="form_login" >
            <input type="text" name="username" placeholder="Enter Username" minlength="4" maxlength="20" required><br>
            <input type="password" name="password" placeholder="Enter Password" minlength="8" maxlength="20" required><br>
            <input class="btn_0" type="submit" value="Sign In"><br>
        </form>
        <form action="<?=URL?>login/register" method="post" id="form_register" style="display: none;">
            <input type="text" name="username" placeholder="username" minlength="4" maxlength="20" required><br>
            <input type="email" name="email" placeholder="your email" size="20" maxlength="60" required><br>
            <input type="password" name="pass1" placeholder="password here" minlength="8" maxlength="20" required><br>
            <input type="password" name="pass2" placeholder="confirm password" minlength="8" maxlength="20" required><br>
            <input type="submit" name="register" value="Register" class="btn_0"><br>
        </form>
        <a href="<?=URL?>login/forgot">Forgot Password?</a>
    </div>
    <script src="<?=URL?>js/login.js"></script>