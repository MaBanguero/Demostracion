define(
    [
        'Magento_Checkout/js/view/payment/default',
        'jquery'
    ],
    function (Component) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'AgSoftware_PayU/payment/payu'
            },
            getMailingAddress: function () {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },
            getInstructions: function () {
                return '' //window.checkoutConfig.payment.instructions[this.item.method];
            },
            pay: function () {
                this.dataForm()
                this.placeOrder();
                console.log(this)
                
            },
            dataForm: function () {
                //    var form= $('form');
                //    var form=document.createElement('form');
                //    form.method="POST";
                //    form.action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/"
                //    form.id="formpayu";
                //    $('#formpayu').submit();
                // var form = $('<form method="post" style="display:none" id="payuform" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">' +
                //     '<input name="merchantId"    type="hidden"  value="508029">' +
                //     '<input name="accountId"     type="hidden"  value="512321">' +
                //     '<input name="description"   type="hidden"  value="Test PAYU">' +
                //     '<input name="referenceCode" type="hidden"  value="TestPayU">' +
                //     '<input name="amount"        type="hidden"  value="20000">' +
                //     '<input name="tax"           type="hidden"  value="3193">' +
                //     '<input name="taxReturnBase" type="hidden"  value="16806">' +
                //     '<input name="currency"      type="hidden"  value="COP">' +
                //     '<input name="signature"     type="hidden"  value="7ee7cf808ce6a39b17481c54f2c57acc">' +
                //     '<input name="test"          type="hidden"  value="1">' +
                //     '<input name="buyerEmail"    type="hidden"  value="test@test.com">' +
                //     '<input name="responseUrl"   type="hidden"  value="http://www.test.com/response">' +
                //     '<input name="confirmationUrl" type="hidden"  value="http://www.test.com/confirmation">' +
                //     '<input name="Submit" type="submit"  value="Enviar" >' +
                //     '</form>');
                let form= new FormData();
                form.append('merchantId','508029')
                form.append('accountId','512321')
                form.append('description','Test PAYU')
                form.append('referenceCode','TestPayU')
                form.append('amount','20000')
                form.append('tax','3193')
                form.append('taxReturnBase','16806')
                form.append('currency','COP')
                form.append('signature','7ee7cf808ce6a39b17481c54f2c57acc')
                form.append('test','1')
                form.append('buyerEmail','test@test.com')
                form.append('responseUrl','http://magento.test/response')
                form.append('confirmationUrl','http://magento.test/confirmation')
                fetch('https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/',{
                    body:form,
                    method:'POST'
                }).then(function(response) {
                    if(response.ok) {
                        // window.location.replace("https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/");
                        return response.text()
                    } else {
                        throw "Error en la llamada Ajax";
                    }
                })
                // $(document.body).append(form);
                // documet.getElementById("payuform").submit();
            }
        });
    }
);
