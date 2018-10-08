// backToTop.js
// for Sun Aviation, Inc.
// created by Avery Wald on 5/25/18
// Copyright (c) Sun Aviation, Incorporated
// All rights reserved.

// apply the function to the browser window
window.onscroll = function() {
    scrollFunction()
};

// when user scrolls down 100px, show button
function scrollFunction() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        document.getElementById("scrollButton").style.display = "block";
    }
    else {
        document.getElementById("scrollButton").style.display = "none";
    }
}

// when user clicks button, scroll to the top of the page
function topFunction() {
    document.body.scrollTop = 0;    // for Safari browser
    document.documentElement.scrollTop = 0;    // for Chrome, Firefox, IE and Opera
}