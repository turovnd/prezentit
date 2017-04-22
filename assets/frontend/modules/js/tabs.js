module.exports = (function (tabs) {


    var tabsArray_ = null,
        nodes_ = [],
        node_ = null,
        noResult = null;

    var prepare_ = function (options) {

        noResult = document.createElement('div');
        noResult.id = 'noResult';
        noResult.style = 'padding: 20px;text-align: center;';
        noResult.innerHTML = 'К сожалению, ничего ненеайдено. Попробуйте изменить запрос';

        tabsArray_ = document.querySelectorAll('[data-toggle="tabs"]');

        if (tabsArray_.length > 0) {

            for (var i = 0; i < tabsArray_.length; i++) {

                node_ = {
                    btn: tabsArray_[i],
                    block: document.getElementById(tabsArray_[i].dataset.block),
                    search: options.search ? document.getElementById(tabsArray_[i].dataset.search) : '',
                    input: options.search ? document.getElementById(tabsArray_[i].dataset.search + 'Input') : '',
                    counter: options.counter ? document.getElementById(tabsArray_[i].dataset.block + 'Counter') : '',
                    searchElements: options.search ? document.getElementById(tabsArray_[i].dataset.block).getElementsByClassName('item__info-name') : ''
                };
                nodes_.push(node_);

                nodes_[i].btn.dataset.id = i;
                nodes_[i].btn.addEventListener('click', changeTab, false);

                if (nodes_[i].input) {

                    nodes_[i].input.dataset.id = i;
                    nodes_[i].input.addEventListener('keyup', searchItem, false);

                }

            }

        }

    };



    tabs.init = function (options) {

        prepare_(options);

    };



    var changeTab = function () {

        for (var i = 0; i < nodes_.length; i++) {

            nodes_[i].btn.classList.remove('tabs__btn--active');
            nodes_[i].block.classList.remove('tabs__block--active');
            if (nodes_[i].search) {

                nodes_[i].search.classList.remove('tabs__search-block--active');

            }

        }

        nodes_[this.dataset.id].btn.classList.add('tabs__btn--active');
        nodes_[this.dataset.id].block.classList.add('tabs__block--active');
        if (nodes_[this.dataset.id].search) {

            nodes_[this.dataset.id].search.classList.add('tabs__search-block--active');

        }

    };


    var searchItem = function () {

        var node = nodes_[this.dataset.id],
            searchingText = new RegExp(node.input.value.toLowerCase()),
            elementBlock, element, elementText;

        for (var i = 0; i < node.searchElements.length; i++) {

            element = node.searchElements[i].getElementsByTagName('a')[0];
            elementBlock = element.parentNode.parentNode.parentNode;
            elementText = element.innerHTML.toLowerCase();

            if ( ! searchingText.test(elementText) ) {

                if (!elementBlock.classList.contains('hide'))
                    node.counter.innerHTML = parseInt(node.counter.innerHTML) - 1;
                element.parentNode.parentNode.parentNode.classList.add('hide');

            } else {

                if (element.parentNode.parentNode.parentNode.classList.contains('hide'))
                    node.counter.innerHTML = parseInt(node.counter.innerHTML) + 1;
                element.parentNode.parentNode.parentNode.classList.remove('hide');

            }

            if (parseInt(node.counter.innerHTML) == 0) {

                elementBlock.parentNode.append(noResult);

            } else if ( document.getElementById('noResult') ) {

                document.getElementById('noResult').remove();

            }


        }

    };

    return tabs;

})({});