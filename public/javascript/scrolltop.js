var back_top_button = document.getElementById("backbtn");

// Whenever end users scroll down 10px from the beginning of the web page, then back to top button visible
window.onscroll = function() {scrollfunc()};

function scrollfunc() {
    if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
        back_top_button.style.display = "block";
    } else {
        back_top_button.style.display = "none";
    }
}

function Scrollback_topfunc() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
