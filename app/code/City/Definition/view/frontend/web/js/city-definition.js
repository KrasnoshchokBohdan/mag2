define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function ($, modal, urlBuilder) {

    var ajaxT = {
        ajaxPostSend: function (form) {
            var url = urlBuilder.build("city-def/index/index");
            $.ajax({
                showLoader: true,
                url: url,
                type: "POST",
                dataType: 'json',
                context: this,
                data: form        //obj
            }).done(function (respond) {
                console.log('Done!');
            });
        }
    };

    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Choose your city',
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
                     cityInfoSend = {
                        content: $('#city123').serializeArray(),
                    };
                    debugger;
                    //$("#modal-btn-city123").attr('title', 'your new title')
                    ajaxT.ajaxPostSend(cityInfoSend);
                    this.closeModal();
                }
        }
        ]
    };


    var cityInfoSend;
    var popup = modal(options, $('#modal-content-city123'));

    $("#modal-btn-city123").click(function () {
        $("#modal-content-city123").modal('openModal');
    });
});


