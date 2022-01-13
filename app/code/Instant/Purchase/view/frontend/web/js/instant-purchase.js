define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function ($, modal, urlBuilder) {

    var ajaxT = {
        ajaxPostSend: function (obj) {
            var url = urlBuilder.build("inst-purchase/index/index");
            $.ajax({
                showLoader: true,
                url: url,
                type: "POST",
                dataType: 'json',
                context: this,
                data: obj
            }).done(function (respond) {
                console.log('Done!');
            });
        }
    };

    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Buy in one click',
        buttons: [{
            text: $.mage.__('Close'),
            class: 'modal-close',
            click: function () {
                this.closeModal();
            }
        },
            {
                text: $.mage.__('Ok'),
                class: 'modal-close',
                click: function () {
                    orderInfoSend = {
                        order: 'test',
                        content: $('#contact-form3').serializeArray(),
                        product: $('#product_addtocart_form').serializeArray()
                    };
                    debugger;
                    ajaxT.ajaxPostSend(orderInfoSend);
                    this.closeModal();
                }
            }
        ]
    };

    var orderInfoSend;
    var popup = modal(options, $('#modal-content-inst'));

    $("#modal-btn-inst").click(function () {
        $("#modal-content-inst").modal('openModal');
    });

});


