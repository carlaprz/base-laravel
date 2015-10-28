(function ($) {
    "use strict";
    var mainApp = {
        initFunction: function () {
            var app = this;
            /*MENU
             ------------------------------------*/
            $('#main-menu').metisMenu();

            $(window).bind("load resize", function () {
                if ($(this).width() < 768) {
                    $('div.sidebar-collapse').addClass('collapse')
                } else {
                    $('div.sidebar-collapse').removeClass('collapse')
                }
            });

            $('[data-product-status] a').on('click', function () {
                var changeStatusUrl = $(this).parent().data('url');
                var productId = $(this).parent().data('product-id');
                var active = 0;

                if (hasAttr($(this), 'data-yes')) {
                    active = 1;
                }

                changeStatusUrl = changeStatusUrl.replace('PROD', productId);
                changeStatusUrl = changeStatusUrl.replace('ACTIVE', active);

                var product = $('[data-is-product-id="' + productId + '"]');
                var parent = $(this).parent();
                product.addClass('processing');

                $(parent).find('a').each(function (index) {
                    //Clear class A
                    $(this).removeClass('product-status-disabled');
                    $(this).removeClass('product-status-default');
                    $(this).removeClass('product-status-enabled');

                    //Add default class
                    $(this).addClass('product-status-default');
                });

                $.get(changeStatusUrl, function () {
                    product.removeClass('processing');
                    if (active == 1) {
                        $(parent).find('a').eq(1).removeClass('product-status-default');
                        $(parent).find('a').eq(1).addClass('product-status-enabled');
                    } else {
                        $(parent).find('a').eq(0).removeClass('product-status-default');
                        $(parent).find('a').eq(0).addClass('product-status-disabled');
                    }
                });
            });

            $('[data-is-delete-url]').on('click', function () {
                var url = $(this).data('href');
                var currentItem = $(this).parent();

                var type = currentItem.data('type');

                $.get(url, function () {
                    app.moveElement(
                            currentItem,
                            '.' + type + ' .panel-body.inactives'
                            );
                });

                return false;
            });
            $("body").on('change', '[data-mapper-select]', function () {
                console.log(true);
                var stuffId = $(this).val();
                if (stuffId == '') {
                    stuffId = 0;
                }

                var url = $(this).data('url').replace('STUFFID', stuffId);

                var currentItem = $(this).parent().parent();
                var type = currentItem.data('type');
                var moveTo = stuffId == 0
                        ? 'news'
                        : 'actives';

                var notMove = $(this).data('not-move');

                $.get(url, function () {
                    if (!notMove) {
                        app.moveElement(
                                currentItem,
                                '.' + type + ' .panel-body.' + moveTo
                                );
                    }
                });
            });

        },
        moveElement: function (element, moveTo) {
            element.fadeOut(function () {
                element.detach().prependTo(moveTo);
                element.fadeIn();
            });
        },
        initialization: function () {
            mainApp.initFunction();
        }

    }
    // Initializing ///

    $(document).ready(function () {
        mainApp.initFunction();
    });

}(jQuery));

function hasAttr(element, attrName) {
    var attr = element.attr(attrName);

    if (typeof attr !== typeof undefined && attr !== false) {
        return true;
    }

    return false;
}
