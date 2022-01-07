define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function ($, modal, urlBuilder) {

    var OrderModal = {
        initModal: function (config, element) {

            var ajaxT = {
                ajaxPostSend: function (obj) {
                    var url = urlBuilder.build("ordercancel/index/index");
                    $.ajax({
                        //   showLoader: true,
                        url: url,
                        type: "POST",
                        dataType: 'json',
                        context: $orderId,     //this
                        beforeSend: function () {
                            $('body').trigger('processStart'); // start loader
                        }

                    }).done(function (respond) {
                        $('body').trigger('processStop');
                        console.log('Done!');
                    });
                }
            };

            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Cancel Order',
                modalLeftMargin: 55,
                buttons: [
                    {
                        text: $.mage.__('Close'),
                        class: 'modal-close',
                        click: function () {
                            console.log("close");
                            this.closeModal();
                        }
                    },
                    {
                        text: $.mage.__('Ok'),
                        class: 'modal-close',
                        click: function () {
                            console.log("ok");
                            ajaxT.ajaxPostSend($orderId);   //this
                            this.closeModal();
                        }
                    }
                ]
            };
            $target = $(config.target);
            $target.modal(options);
            $element = $(element);
            $orderId = $element.attr('id');

            $element.click(function () {
                $target.modal('openModal');
            });
        }
    };
    return {
        'order-modal': OrderModal.initModal
    };
});


