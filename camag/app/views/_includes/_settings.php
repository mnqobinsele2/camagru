<div class="form_container">
    <form action="<?=URL?>settings/setupdate" method="post">
        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert"><?=Session::get('error')?></div>
        <?php endif ?>
        <input type="text" name="username" class="input" value="<?=Session::get('user')?>"><br>
        <input type="email" name="email" class="input" value="<?=Session::get('email')?>"><br>
        <input type="password" name="pass1" class="input" placeholder="new password"><br>
        <input type="password" name="pass2" class="input" placeholder="confirm new password"><br>
        <div class="alert">Comment Notifications</div>
        <div class="radio">
            <input type="radio" name="notifs" class="" value="true"> Enable
            <input type="radio" name="notifs" class="" value="false"> Disable<br>
        </div>
        <br>
        <input type="submit" class="btn_0" value="Update Settings">
    </form>
</div>