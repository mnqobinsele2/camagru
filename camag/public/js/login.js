function loginSwitch(el) {
    if (el.id == 'l_btn_0') {
        el.setAttribute('class', 'l_btn_0');
        document.getElementById('l_btn_1').setAttribute('class', 'l_btn_1');
        document.getElementById('form_login').style.display = 'initial';
        document.getElementById('form_register').style.display = 'none';
    } else if (el.id == 'l_btn_1') {
        el.setAttribute('class', 'l_btn_0');
        document.getElementById('l_btn_0').setAttribute('class', 'l_btn_1');
        document.getElementById('form_login').style.display = 'none';
        document.getElementById('form_register').style.display = 'initial';
    }

}