define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'mage/url'
], function (
    $,
    ko,
    Component,
    quote,
    urlBuilder
) {
    'use strict';

    var cardUrl = ko.observable('');

    return Component.extend({
        defaults: {
            tracks: {notAvailableStr: " "},
            template: 'Checkout_InternationalDelivery/checkout/shipping/additional-block'
        },
        initObservable: function () {
             this._super();

            this.selectedMethod = ko.computed(function () {
                    var method = quote.shippingMethod();
                    var selectedMethod = null;
                if (method != null) {
                    selectedMethod = method.method_code;
                    this.ajaxPostSend(this);
                }
                    return selectedMethod;
            },
                this);

            return this;
        },

        ajaxPostSend: function (obj) {

            var url = urlBuilder.build("international/index/index");
            obj.cardUrl = urlBuilder.build("checkout/cart/");
            $.ajax({
                showLoader: true,
                url: url,
                type: "POST",
                dataType: 'json',
                context: this

            }).done(function (respond) {
                $('.continue').attr('disabled', false);
                if (respond.success === true) {
                    $('.continue').attr('disabled', true);
                    this.notAvailableStr = 'This item(s), '+respond.items+', is not available for international shipping please remove from your cart.';
                }
            });
        },
    });
});
