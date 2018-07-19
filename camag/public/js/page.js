var btnPrev = document.getElementById('btn_prev'),
    btnNext = document.getElementById('btn_next');
    butt_close = document.getElementsByClassName('closeBtn')[0];

btnPrev.addEventListener('click', prevNav);
btnNext.addEventListener('click', nextNav);

function pagingNav(){

    var countPage = document.getElementById('currPage');
    if (paging[1] <= 1){
        btnPrev.disabled = true;
        btnNext.disabled = true;
    } else if ((paging[2] == 1) && (paging[1] > 1)){
        btnPrev.disabled = true;
        btnNext.disabled = false;
    } else if ((paging[2] == paging[1]) && (paging[2] > 1)){
        btnPrev.disabled = false;
        btnNext.disabled = true;
    } else {
        btnPrev.disabled = false;
        btnNext.disabled = false;
    }
    countPage.innerText = 'Page ' + paging[2] + ' of ' + paging[1] + '.';
}



function pageViews(){
    countImages(paging[3]);
}

function nextNav(){
    paging[0] += paging[3];
    paging[2] = paging[2] + 1;
    if(document.getElementById('gallery')){
        loadGallery();
    }else {
        loadImages();
    }
    pageViews();
    pagingNav();
}

function prevNav(){
    paging[0] -= paging[3];
    paging[2] = paging[2] - 1;
    if(document.getElementById('gallery')){
        loadGallery();
    }else {
        loadImages();
    }
    pageViews();
    pagingNav();
}
if(document.getElementById('gallery')){
    loadGallery();  
}
pageViews();


