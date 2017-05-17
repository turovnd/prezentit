module.exports = (function (draw) {

    /**
     * Draws node
     * @param tagName
     * @param className
     * @param properties
     * @returns {Element}
     */
    draw.node = function (tagName, className, properties) {

        var tag = document.createElement(tagName);

        tag.className += className;

        for(var property in properties) {

            tag.setAttribute(property, properties[property]);

        }

        return tag;

    };

    return draw;

})({});
