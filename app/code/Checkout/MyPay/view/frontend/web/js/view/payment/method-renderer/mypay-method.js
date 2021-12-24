/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* @api */
define([
    'Magento_Checkout/js/view/payment/default'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Checkout_MyPay/payment/mypay'
        },

        /**
         * Returns payment method instructions.
         *
         * @return {*}
         */
        getInstructions: function () {
            return window.checkoutConfig.payment.instructions[this.item.method];
        }
    });
});
