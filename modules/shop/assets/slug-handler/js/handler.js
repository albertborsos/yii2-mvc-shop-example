$(function() {
    var handler = {
        init: function () {
            this.cacheDOM();
            this.bindEvents();
        },
        cacheDOM: function () {
            this.$source = $('.slug-source');
            this.$result = $('.slug-result');
        },
        bindEvents: function () {
            this.$source.on('keyup', function () {
                var title = handler.$source.val();
                handler.$result.val(handler.slugify(title));
            })
        },
        slugify: function (text) {
            // Use hash map for special characters
            let specialChars = {"à":'a',"ä":'a',"á":'a',"â":'a',"æ":'a',"å":'a',"ë":'e',"è":'e',"é":'e', "ê":'e',"î":'i',"ï":'i',"ì":'i',"í":'i',"ò":'o',"ó":'o',"ö":'o',"ő":'o',"ô":'o',"ø":'o',"ù":'o',"ú":'u',"ü":'u',"ű":'u',"û":'u',"ñ":'n',"ç":'c',"ß":'s',"ÿ":'y',"œ":'o',"ŕ":'r',"ś":'s',"ń":'n',"ṕ":'p',"ẃ":'w',"ǵ":'g',"ǹ":'n',"ḿ":'m',"ǘ":'u',"ẍ":'x',"ź":'z',"ḧ":'h',"·":'-',"/":'-',"_":'-',",":'-',":":'-',";":'-'};

            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/./g,(target, index, str) => specialChars[target] || target) // Replace special characters using the hash map
                .replace(/&/g, '-and-')         // Replace & with 'and'
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }
    };

    handler.init();
});
