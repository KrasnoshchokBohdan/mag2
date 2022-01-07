define([
        'jquery',
        'Magento_Ui/js/modal/modal',
        'mage/url'
    ], function ($, modal, urlBuilder) {

        var OrderModal = {
            initModal: function (config, element) {

                var ajax = {
                    ajaxPostSend: function (obj) {
                        var url = urlBuilder.build("ordercancel/order/cancel");
                        $.ajax({
                            showLoader: true,
                            url: url,
                            type: "POST",
                            dataType: 'json',
                            context: this

                        }).done(function (respond) {
                            if (respond.success === true) {
                                console.log('Done!');
                            }
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
                                ajax.ajaxPostSend(this);
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

//  modal(options, $('#modal-content'));
//  $(".modal-btn").on('click', function () {
//      $("#modal-content").modal("openModal");
//  });


// return {

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
)
;


