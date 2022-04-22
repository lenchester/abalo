"use strict"
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options = {}) {

    options = {
        path: '/',
        // при необходимости добавьте другие значения по умолчанию
    };

    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
    }

    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }

    document.cookie = updatedCookie;
}
function deleteCookie(name) {
    setCookie(name, "", {
        'max-age': -1
    })
}

function acceptCookieConsent(){
    deleteCookie('cookieaccept');
    setCookie('cookieaccept', 1, 360);
    document.getElementById("cookieNotice").style.display = "none";
}

let cookie_consent = getCookie("cookieaccept");
if(cookie_consent != ""){
    document.getElementById("cookieNotice").style.display = "none";
}else{
    document.getElementById("cookieNotice").style.display = "block";
    //setCookie('cookieaccept', 'true', {secure: true, 'max-age': 3600});
    //document.getElementById("cookieNotice").style.display = "none";
}

deleteCookie("cookieaccept");
console.log("cookieaccept=" + getCookie("cookieaccept"));
