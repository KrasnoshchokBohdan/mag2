define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function ($, modal, urlBuilder) {

    var OrderModal = {
        /**
         *
         * @param config
         * @param element
         */
        initModal: function (config, element) {

            var ajaxT = {
                /**
                 *
                 * @param obj
                 */
                ajaxPostSend: function (obj) {
                    var url = urlBuilder.build("ordercancel/index/cancel");
                    $.ajax({
                        showLoader: true,
                        url: url,
                        type: "POST",
                        dataType: 'json',
                        context: this,
                        data: obj
                    }).done(function (respond) {
                        console.log('Done!');
                        window.location.reload();
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
                            orderIdsend = {
                                order: $('#id-button').val(),
                                content: $('#contact-form2').serializeArray()
                            };
                            ajaxT.ajaxPostSend(orderIdsend);
                            this.closeModal();
                        }
                }
                ]
            };
            $target = $(config.target);
            $target.modal(options);
            $element = $(element);
            var orderIdsend = {
                order: '',
                content: ''
            };
            $element.click(function () {
                $('#id-button').val(this.getAttribute('id'));
                $target.modal('openModal');
            });
        }
    };
    return {
        'order-modal': OrderModal.initModal
    };
});


