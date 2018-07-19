<div class="form_container">
    <div class="alert">Enter New Password</div>
    <form action="<?=URL?>forgot/reset" class="" method="post" id="reset_1">
        <input type="hidden" name="ver" class="input" value="<?=$_GET['ver']?>" readonly><br/>
        <input type="email" name="email" class="input" value="<?=$_GET['email']?>" readonly><br/>
        <input type="password" name="password" class="input" placeholder="your new password here" required><br/>
        <input type="submit" name="reset_pass" class="btn_0" value="Reset Password" id="resetPw">
    </form>
</div>