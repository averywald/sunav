// accordion.js
// for Sun Aviation, Inc.
// created by Avery Wald on 5/23/18
// Copyright (c) Sun Aviation, Incorporated
// All rights reserved.

// accordion functionality

// array of accordion objs
var accordions = document.getElementsByClassName("accordion");

// loop through array and create click event for each one
for (var i = 0; i < accordions.length; i++) {
    accordions[i].onclick = function() {
        // toggle obj class to "active" when clicked
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight) {
            // accordion is open, need to close
            content.style.maxHeight = null;
        }
        else {
            // accordion is closed
            content.style.maxHeight = content.scrollHeight + "px";
        }
    }
}