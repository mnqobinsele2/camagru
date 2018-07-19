var paging = [0, 1, 1, 10];
var modal = document.getElementById('comment_modal');

window.addEventListener('click', modalOut);

function hideCom() {
    document.getElementById('com_sec').style.visibility = 'hidden';
}


function modalOut(e) {
    if (e.target == modal || e.target == butt_close) {
        modal.style.visibility = 'hidden';
    }
}

function setComment(id) {
    var obj = document.getElementById('com_id');

    obj.setAttribute('value', id);
    modal.style.visibility = 'visible';
    getComments(id);
    isLiked(id);
}

// getComments()
function getComments(id) {
    var obj = document.getElementById('com_id');

    document.getElementById('coms').innerHTML = '';
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/camagru/public/gallery/comments?getCom=' + id, true);

    xhr.onload = function() {
        if (this.status == 200) {
            var comments = JSON.parse(this.responseText);
            if (comments.length == 0) {
                document.getElementById('coms').innerHTML = 'No comments for this photo';
                return;
            }
            for (var i = 0; i < comments.length; i++) {
                if (i > 0 && i < comments.length) {
                    document.getElementById('coms').innerHTML += '<hr/>';
                }
                document.getElementById('coms').innerHTML += '<div class="comment"><h4>' +
                    comments[i].username + '</h4><p>' + comments[i].comment + '</p><small>' +
                    comments[i].date_comment +
                    '</small></div>'
            }
        }
    }
    xhr.send();
}

// setLikes
function setLike() {
    var obj = document.getElementById('com_id');
    var xhr = new XMLHttpRequest();

    xhr.open('POST', '/camagru/public/gallery/like');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        isLiked(obj.value);
        countLC(obj.value);
    };
    xhr.send('like=' + obj.value);
}



function isLiked(id) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/camagru/public/gallery/checklikes?isLiked=fetch&imgID='+id, true);

    xhr.onload = function() {
        if (this.status == 200) {
            var liked = parseInt(this.responseText);
            if (document.getElementById('butt_like')){
                if (liked > 0) {
                    document.getElementById('butt_like').style.display = 'none';
                } else {
                    document.getElementById('butt_like').style.display = 'initial';
                    
                }
            }
        }
    }
    xhr.send();
}

function loadGallery() {
    document.getElementById('gallery').innerHTML = '';
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/camagru/public/gallery/getgallery?start='+paging[0]+'&end='+paging[3], true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            //var arr = Array.parse(this.responseText);
            //alert(arr);
            var gall_images = JSON.parse(this.responseText);
            for (var i = 0; i < gall_images.length; i++) {
                document.getElementById('gallery').innerHTML += 
                '<div class="gallImage"><img src="/'+gall_images[i].image+
                '" onclick="setComment('+gall_images[i].id +')"><br><div id="likes_'+
                gall_images[i].id+'" onclick="setComment('+gall_images[i].id +')">'+'</div><div id="coms_'+gall_images[i].id+
                '" onclick="setComment('+gall_images[i].id +')"></div></div>';
                countLC(gall_images[i].id);
            }
        }
    }
    xhr.send();
}

function countImages(num) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/camagru/public/gallery/gallery_count?imgNum=fetch', true);

    xhr.onload = function() {
        if (this.status == 200) {
            var num_images = parseInt(this.responseText);
            paging[1] = Math.ceil(num_images / num);
            if (paging[1] == 0) {
                paging[1] = 1;
            }
            pagingNav();
        }
    }
    xhr.send();
}

function countLC(id) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/camagru/public/gallery/lc_counts?img_id=' + id, true);

    xhr.onload = function() {
        if (this.status == 200) {
            var lc = JSON.parse(this.responseText);
            document.querySelector('#likes_'+id).innerText = lc[0].total + ' Likes';
            document.querySelector('#coms_'+id).innerText = lc[1].total + ' Comments';
        }
    }
    xhr.send();
}