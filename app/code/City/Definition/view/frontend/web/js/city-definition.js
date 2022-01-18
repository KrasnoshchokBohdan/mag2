define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url',
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
                    ajaxT.ajaxPostSend(cityInfoSend);
                   // var city = cityInfoSend['content'].valueOf();
                   // $.cookie('city1', city[0].value, { path: '/' });
                    this.closeModal();
                }
            }
        ]
    };

    var options1 = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Your city?',
        buttons: [{
            text: $.mage.__('Yes'),
            class: 'modal-close',
            click: function () {
                this.closeModal();
            }
        },
            {
                text: $.mage.__('Choose Another'),
                class: 'modal-close',
                click: function () {
                    $("#modal-content-city").modal('openModal');
                    this.closeModal();
                }
            }

        ]
    };


    var cityInfoSend;
    var popup = modal(options, $('#modal-content-city'));
    var popup1 = modal(options1, $('#modal-custom-city'));


    $("#modal-btn-custom-city").click(function () {
        $("#modal-custom-city").modal('openModal');
    });
});


