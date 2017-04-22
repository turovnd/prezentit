module.exports = (function (collapse) {


    collapse.nodes = [];
    collapse.btn = null;
    collapse.list = null;


    collapse.init = function () {

        collapse.nodes = document.querySelectorAll('[data-toggle="collapse"]');

        if (collapse.nodes.length > 0) {

            for (var i = 0; i < collapse.nodes.length; i++) {

                collapse.nodes[i].addEventListener('click', toggle, false);

                if(collapse.nodes[i].dataset.opened == 'true') {

                    openCollapse(collapse.nodes[i], document.getElementById(collapse.nodes[i].dataset.area));

                }

            }

        }

    };


    var toggle = function (event) {

        collapse.btn = event.target;

        if (!collapse.btn.classList.contains('aside__link')) {

            collapse.btn = collapse.btn.parentNode;

        }

        collapse.list = document.getElementById(collapse.btn.dataset.area);

        if (collapse.btn.dataset.opened === 'false') {

            openCollapse(collapse.btn, collapse.list);

        } else {

            hideCollapse(collapse.btn, collapse.list);

        }

    };


    var openCollapse = function (btn, list) {

        btn.dataset.opened = 'true';

        if (!list.dataset.height)
            list.dataset.height = calculateHeight(list);

        list.style.height = list.dataset.height + 'px';

    };


    var hideCollapse = function (btn, list) {

        btn.dataset.opened = 'false';
        list.style.height = '0';

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