/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'ko',
    'jquery',
    'underscore',
    'uiComponent',
    'Magento_Ui/js/modal/confirm',
    'Magento_Customer/js/customer-data',
    'mage/url',
    'mage/template',
    'mage/translate',
    'text!Magento_InstantPurchase/template/confirmation.html',
    'text!Dev101_OSCheckout/template/confirmation.html',
    'mage/validation'
], function (ko, $, _, Component, confirm, customerData, urlBuilder, mageTemplate, $t, confirmationTemplate,customConfirmationTemplate) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'dynamic-sc',
            Url: urlBuilder.build('DynamicSC/Ajax/PriceByQtyUpdate'),

        },

        show: function()  {
            var form = $(this.productFormSelector);
                        $.ajax({
                            url: this.Url,
                            data: form.serialize(),
                            type: 'post',
                            dataType: 'json',

                            /** Show loader before send */
                            beforeSend: function () {
                                $('body').trigger('processStart');
                            }
                        }).always(function () {
                            $('body').trigger('processStop');
                        });
                    },
                });
            });
