define([
        'jquery',
        'Magento_Ui/js/modal/modal',
        'mage/url'
    ], function ($, modal, urlBuilder) {

        var OrderModal = {
            initModal: function (config, element) {

                var options = {
                    type: 'popup',
                    responsive: true,
                    innerScroll: true,
                    title: 'Cancel Order',
                    modalLeftMargin: 55,
                    buttons: [{
                        text: $.mage.__('Close'),
                        class: 'modal-close',
                        click: function () {
                            this.closeModal();
                        }
                    }]
                };


                $target = $(config.target);
                $target.modal(options);
                $element = $(element);
                $element.click(function () {
                    $target.modal('openModal');
                });
            }
        };
        return {
            'order-modal': OrderModal.initModal
        };

        //  modal(options, $('#modal-content'));
        //  $(".modal-btn").on('click', function () {
        //      $("#modal-content").modal("openModal");
        //  });


        // return {
        //     var urlTest = urlBuilder.build("ordercancel/order/cancel");
        //
        //     exampleData:function(urlTest){
        //         $(".modal-btn").click(function(e) {
        //             e.preventDefault();
        //             //     var $form = $('#contact-form2');     //what???????
        //             //     var data = $('#contact-form2').serialize();   //what???????
        //             //    if(!$form.valid()) return false;
        //             $.ajax({
        //                 url:urlTest,
        //                 type:'POST',
        //                 showLoader: true,
        //                 dataType:'json',
        //                 data: data,
        //                 complete: function(data) {
        //                     // $('#email_address').val("");   //what???????
        //                     modal(options, $('#modal-content')).modal('openModal');
        //                 },
        //                 error: function (xhr, status, errorThrown) {
        //                     console.log('Error happens. Try again.');
        //                 }
        //             });
        //         });
        //   }
        //    }


    }
);


