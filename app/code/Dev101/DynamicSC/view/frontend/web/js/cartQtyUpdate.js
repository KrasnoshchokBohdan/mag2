define([
    'jquery',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data',
    'mage/url'
], function ($, getTotalsAction, customerData, urlBuilder ) {

    $(document).ready(function(){
        $(document).on('change', 'input[name$="[qty]"]', function(){
            var form = $('form#form-validate');
            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                showLoader: true,
                success: function (res) {
                   /** var parsedResponse = $.parseHTML(res);
                    var result = $(parsedResponse).find("#form-validate");
                    var sections = ['cart'];

                    $("#form-validate").replaceWith(result);
                    customerData.reload(sections, true);
                    var deferred = $.Deferred();
                    getTotalsAction([], deferred); */
                    document.location.reload();
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        });
    });

        var selectSZ=document.querySelectorAll('div#sz.swatch-option.text');
        var selectClr=document.querySelectorAll('div#clr.swatch-option.text');
        var arrSZ=Array.from(selectSZ);
        var arrClr=Array.from(selectClr);

        arrSZ.forEach(function(el)
        {
           el.addEventListener('click', selectCell)
        });
        arrClr.forEach(function(el)
        {
           el.addEventListener('click', selectCell)
        });

    function selectCell(event)
    {
        target = event.target;
        var unselectSZ=document.querySelector('div#sz.swatch-option.text.selected');
        var unselectClr=document.querySelector('div#clr.swatch-option.text.selected');
        if((unselectSZ==null || unselectClr == null)){
            this.setAttribute('class','swatch-option text selected');


        }
        if((unselectSZ!==null) && (unselectClr!==null)){
            this.setAttribute('class','swatch-option text');
        }

        var reselectSZ=document.querySelector('div#sz.swatch-option.text.selected');
        var reselectClr=document.querySelector('div#clr.swatch-option.text.selected');
        if(( reselectSZ != null && reselectClr !== null)) {
            var reloadSZ=document.querySelector('div#sz.swatch-option.text.selected');
            var reloadClr=document.querySelector('div#clr.swatch-option.text.selected');
            var size=reloadSZ.innerText;
            var color=reloadClr.innerText
            //var itemId=document.querySelector('.item-qty.cart-item-qty').getAttribute('data-cart-item');
            var itemId=reloadSZ.getAttribute('data-item');
            var product=document.querySelector('#custom-product-'+itemId).innerHTML;
            $.ajax({
                url: urlBuilder.build('DynamicSC/Ajax/PriceByQtyUpdate'),
                data:  {
                    size: size,
                    product: product,
                    item: itemId,
                    color: color
                },
                type: 'post',
                dataType: 'json',
                showLoader: true,
                beforeSend: function () {
                    $('body').trigger('processStart');
                },
                success: function (data) {
                   // var result = JSON.stringify(data);
                    //$('input#custom-data').html(data['something']);
                   // var input=document.querySelector('img.product-image-photo');
                   // input.setAttribute('src', (data['something']));
                    upgradeCart(data);
                    $('body').trigger('processStop');


                },
                //complete: function (result) {

               // },
                error: function (xhr, status, error) {
                    var err ="Something WRONG!";
                    console.log(err);
                },

            });

            }

        }


         function upgradeCart(data) {
            // var string = document.querySelector('input#custom-data').innerHTML;
            // var super_attribute = JSON.parse(string);
             //var itemId=document.querySelector('.item-qty.cart-item-qty').getAttribute('data-cart-item');
             var reloadSZ=document.querySelector('div#sz.swatch-option.text.selected');
             var itemId=reloadSZ.getAttribute('data-item');
             var product=document.querySelector('#custom-product-'+itemId).innerHTML;
             var form_rep = $("input[name*='form_key']").val();
             var form = $('form#form-validate').serialize();
             var formkey=form.replace('form_key=','');
             var qty = document.querySelector('input#cart-' + itemId + '-qty.input-text.qty').value;
             var url = urlBuilder.build('checkout/cart/updateItemOptions/id/' + itemId + '/');
             $.ajax({
                 url: url,
                 data: {
                     form_key: formkey,
                     product: product,
                     item: itemId,
                     qty: qty,
                     super_attribute: data,
                 },
                 type: 'post',
                 dataType: 'json',
                 showLoader: true,
                 beforeSend: function () {
                     $('body').trigger('processStart');
                 },
                 success: function (res) {

                     var parsedResponse = $.parseHTML(res);
                     var result = $(parsedResponse).find("#form-validate");
                     var sections = ['cart'];

                     $("#form-validate").replaceWith(result);
                     customerData.reload(sections, true);
                     var deferred = $.Deferred();
                     getTotalsAction([], deferred);

                     $('body').trigger('processStop');
                 },
                 complete: function () {
                     document.location.reload();
                     //$('body').trigger('processStop');
                 },
                  error: function (xhr, status, error) {
                            var err ="Something WRONG!";
                            console.log(err);
                        }
             });
         }

});
