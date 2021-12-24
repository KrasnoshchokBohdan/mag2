define([
    'mage/utils/wrapper'
], function (wrapper) {
    'use strict';

    return function (payloadExtender) {
        return wrapper.wrap(payloadExtender, function (originalPayloadExtender, payload) {
            originalPayloadExtender(payload);
            payload.addressInformation['extension_attributes']['comment'] =  document.getElementsByClassName('form form-comment')[0].getElementsByTagName('textarea')[0].value;              //$('[name="shipping_comment"]').val();
        });
    };
});
