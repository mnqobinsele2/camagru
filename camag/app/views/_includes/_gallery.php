<div id="gallery"></div>
<div class="clear"></div>
<div class="modal" id="comment_modal">
    <div class="modal-content">
        <span class="closeBtn">&times</span>
        <div class="clear"></div>
        <div class="com_view" id="coms"></div>
        <?php if (Session::loggedIn() && (Session::get('stat') == 'Yes')): ?>
        <form action="<?=URL?>gallery/comment" method="post">
            <input type="hidden" name="img" value="" id="com_id">
            <textarea name="comment" width="100%"></textarea><br>
            <button type="submit">Comment</button> <button id="butt_like" type="button" onclick="setLike()">Like</button>
        </form>
        <?php else: ?>
            <input type="hidden" name="img" value="" id="com_id">
        <?php endif ?>
    </div>
</div>
<br>
<div id="pagination">
    <button class="btn_0" id="btn_prev">&lt;</button>
    <span id="currPage"></span>
    <button class="btn_0" id="btn_next">&gt;</button>
</div>
<script src="<?=URL?>js/gallery.js"></script>
<script src="<?=URL?>js/page.js"></script>
