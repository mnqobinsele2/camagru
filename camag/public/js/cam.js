var cam = document.getElementById('cam'),
    frame = document.getElementById('frame'),
    previewImg = document.getElementById('preview'),
    side_images = [],
    canvas = document.getElementById('canvas'),
    ctx = canvas.getContext('2d'),
    capture = document.getElementById('capture'),
    new_pic = document.getElementById('newPic'),
    constraints = {
        audio: false,
        video: true
    },
    paging = [0, 1, 1, 6];

function success(stream) {
    if ("srcObject" in cam) {
        cam.srcObject = stream;
    } else {
        cam.src = window.URL.createObjectURL(stream);
    }
    cam.onloadedmetadata = function(e) {
        cam.play();
    }
}

function failure(error) {
    alert('There has been a problem accessing the camera.');
}

function streamCamera() {
    loadImages();
    if (navigator.mediaDevices.getUserMedia)
        navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
            success(stream);
        }).catch((error) => {
            failure(error);
        });
    else
        alert('Your browser does not support streaming, try the file upload instead');
}
//_______________________AJAX CALLS________________________
// Load Images
function loadImages() {
    document.getElementById('side_sec').innerHTML = '';
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/camagru/public/home/get_images?q=imgs&a='+paging[0]+'&z='+paging[3], true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            side_images = JSON.parse(this.responseText);
            if (side_images.length == 0 && paging[1] > 1) {
                prevNav();
            }
            for (var i = 0; i < side_images.length; i++) {
                document.getElementById('side_sec').innerHTML += 
                '<div class="pic_thumb"><img src="/' + side_images[i].image + '"><button class="btn_1" id="'+side_images[i].image+'" onclick="deleteImage(this)">Delete</button></div>';
            }
        }
    }
    xhr.send();
}

// Delete Image
function deleteImage(el) {
    var confirmation = confirm('Are You Sure You Want To Delete This Image?');
    var file = el.id;
    if (confirmation == true) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/camagru/public/files/delete', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (this.status == 200) {
                loadImages();
                pageViews();
            }
        }
        xhr.send('delete=' + file);
    }
}

streamCamera();
// UPLOAD
function previewFile() {
    var preview = document.querySelector('#preview');
    var file    = document.querySelector('#uploadImg').files[0];
    var reader  = new FileReader();
  
    reader.addEventListener("load", function () {
      preview.src = reader.result;
    }, false);
  
    if (file) {
      reader.readAsDataURL(file);
    }
  }
//FRAMES

function changeFrame(el) {
    var src = el.src;
    frame.src = src;
    frame.style.visibility = 'visible';
    capture.style.visibility = 'visible';

    if (new_pic.style.visibility == 'visible') {
        new_pic.style.visibility = 'hidden';
        loadImages();
    }
}

function newImage() {
    if (capture.style.visibility == 'visible') {
        capture.style.visibility = 'hidden';
        new_pic.style.visibility = 'visible';
    } else {
        capture.style.visibility = 'visible';
        new_pic.style.visibility = 'hidden';
    }
}

//CAPTURE
new_pic.addEventListener('click', function() {
    capture.style.visibility = 'hidden';
    new_pic.style.visibility = 'hidden';
    frame.style.visibility = 'hidden';
    frame.src = '';
    previewImg.src = '';
    loadImages();
});

capture.addEventListener('click', function() {
    ctx.drawImage(cam, 0, 0, 800, 600);
    ctx.drawImage(previewImg, 0, 0, 800, 600);
    ctx.drawImage(frame, 0, 0, 800, 600);

    var data = canvas.toDataURL("image/png");
    var xhr = new XMLHttpRequest();

    xhr.open('POST', '/camagru/public/home/upload');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        loadImages();
        pageViews();
    };
    xhr.send('image=' + data);
    frame.src = data;
    newImage();
});

function countImages(num) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/camagru/public/files/image_count?imgNum=fetch', true);

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