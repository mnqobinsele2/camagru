<?php if($_SESSION['stat'] == 'Yes'):?>
<section id="cam_view">
    <div class="container_1">
        <section id="main">
            <div id="main_sec">
                <video src="" id="cam" width="100%" height="100%"></video>
                <img src="" with="100%" height="100%" id="preview" alt="">
                <img src="" with="100%" height="100%" id="frame">
                <button id="capture"><img src="<?=URL?>icons/camera.png"></button>
                <button id="newPic"><img src="<?=URL?>icons/new.png"></button>
            </div>
            <input type="file" name="pic" id="uploadImg" onchange="previewFile()">
            <div class="superposables">
                <div id="sp_img">
                    <img src="<?=URL?>/superposables/1.png" onclick="changeFrame(this)">
                </div>
                <div id="sp_img">
                    <img src="<?=URL?>superposables/2.png" onclick="changeFrame(this)">
                </div>
                <div id="sp_img">
                    <img src="<?=URL?>superposables/3.png" onclick="changeFrame(this)">
                </div>
                <div id="sp_img">
                    <img src="<?=URL?>superposables/4.png" onclick="changeFrame(this)">
                </div>
                <div id="sp_img">
                    <img src="<?=URL?>superposables/5.png" onclick="changeFrame(this)">
                </div>
            </div>
        </section>
        <aside id="sidebar">
            <h3>RECENT PICTURES</h3>
            <p id="side_sec"></p>
            <div id="pagination">
                <button class="btn_0" id="btn_prev">&lt;</button>
                <span id="currPage"></span>
                <button class="btn_0" id="btn_next">&gt;</button>
            </div>
        </aside>
    </div>
    <canvas id="canvas" width="800" height="600"></canvas>
</section>
<script src="<?=URL?>js/cam.js"></script>
<script src="<?=URL?>js/page.js"></script>
<?php else:?>
<div class="form_container">
    <h2>You have to activate your account first to be able to access this area!</h2>
</div>
<?php endif?>