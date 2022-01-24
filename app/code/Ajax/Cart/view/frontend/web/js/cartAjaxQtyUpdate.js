define([
    'jquery',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data',
    'Magento_Checkout/js/model/cart/cache',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'Magento_Checkout/js/model/quote'
], function ($, getTotalsAction, customerData, cartCache, totalsProcessor, quote) {

    $(document).ready(function () {
        $(document).on('change', 'input[name$="[qty]"]', function () {
            let form = $('form#form-validate');
            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                showLoader: true,
                success: function (res) {
                    let parsedResponse = $.parseHTML(res);
                    let result = $(parsedResponse).find("#form-validate");
                    let sections = ['cart'];

                    $("#form-validate").replaceWith(result);

                    // The mini cart reloading
                    customerData.reload(sections, true);

                    // The totals summary block reloading
                    let deferred = $.Deferred();
                    getTotalsAction([], deferred);
                },
                error: function (xhr, status, error) {
                    let err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        });
        $(document).on('change', 'input[name=coupon_code]', function () {
            let form = $('#discount-coupon-form');
            $.ajax(
                {
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function (response) {
                        console.log(response);
                        cartCache.clear('cartVersion');
                        totalsProcessor.estimateTotals(quote.shippingAddress());
                    }
                }
            );
        });

    });
});


