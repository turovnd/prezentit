var collapse = (function(collapse) {


    var nodes = [];


    collapse.init = function() {

        nodes = document.querySelectorAll('[data-toggle="collapse"]');

        if (nodes.length > 0) {

            for (var i = 0; i < nodes.length; i++) {

                nodes[i].addEventListener('click', toggle, false);

                if(nodes[i].dataset.opened == "true") {
                    openCollapse(nodes[i], document.getElementById(nodes[i].dataset.area));
                }

            }
        }

    };


    var toggle = function (event) {
        var btn = event.target,
            list = document.getElementById(btn.dataset.area);

        if (btn.dataset.opened == "false") {
            openCollapse(btn,list);
        } else {
            hideCollapse(btn,list);
        }

    };


    var openCollapse = function (btn, list) {
        btn.dataset.opened = "true";

        if (!list.dataset.height)
            list.dataset.height = calculateHeight(list);

        list.style.height = list.dataset.height + "px";

    };


    var hideCollapse = function (btn, list) {
        btn.dataset.opened = "false";
        list.style.height = "0";
    };


    var calculateHeight = function (list) {
        var height = 0;
        for (var i = 0; i < list.childNodes.length; i++) {
            if (list.childNodes[i].className) {
                height += list.childNodes[i].clientHeight;
            }
        }
        return height;
    };


    return collapse;


})({});