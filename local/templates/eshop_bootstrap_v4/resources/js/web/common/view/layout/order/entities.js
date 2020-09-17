import View from '../../../../app/core/component/view';

class Entities extends View {

    getPropertiesBlock(data, response) {
        let _this = this;
        let resultBlock = $('<div>', {});
        let k = 0;
        console.log(data)
        $.each(data, (i, property) => {
            let propClass;

            if (property.TYPE != 'LOCATION' && property.CODE.indexOf('UR_') < 0) {

                if (property.SIZE < 100) {
                    if (k % 2) {
                        propClass = 'form-row-last';
                    } else {
                        propClass = 'form-row-first';
                    }

                    k++;
                } else {
                    propClass = 'form-row-wide';
                }

                let propBlock = $('<p>', {
                    class: 'form-row form-row validate-required ' + propClass
                });

                let labelBlock = $('<label>', {
                    for: 'soa-property-' + property.ID,
                    text: property.NAME + ' '
                });

                if (property.REQUIRED) {
                    $('<abbr>', {
                        title: 'обязательно',
                        class: 'required',
                        text: '*'
                    }).appendTo(labelBlock);
                }

                let inputBlock = $('<input>', {
                    id: 'soa-property-' + property.ID,
                    name: 'order[ORDER_PROP_' + property.ID + ']',
                    type: 'text',
                    placeholder: property.NAME,
                    value: property.VALUE[0],
                    class: 'input-text'
                });

                labelBlock.appendTo(propBlock);
                inputBlock.appendTo(propBlock);

                propBlock.appendTo(resultBlock);
            } else if (property.CODE.indexOf('UR_') >= 0) {

                if(property.CODE == 'UR_SOBS') {
                    if (property.SIZE < 100) {
                        if (k % 2) {
                            propClass = 'form-row-first';
                        } else {
                            propClass = 'form-row-last';
                        }

                        k++;
                    } else {
                        propClass = 'form-row-wide';
                    }

                    let propBlock = $('<p>', {
                        class: 'form-row col-md-6 form-row validate-required ' + propClass,
                        style: 'margin-top: 25px'
                    });

                    let br = $('<br>');


                    let labelBlock = $('<label>', {
                        for: 'soa-property-' + property.ID,
                        text: property.NAME + ' ',


                    });

                    let inputBlock = $('<input>', {
                        id: 'soa-property-' + property.ID + '-1',
                        name: 'order[ORDER_PROP_' + property.ID + ']',
                        type: 'radio',
                        placeholder: property.NAME,
                        value: 'ИП',
                        class: 'input-checkbox'
                    })

                    let inputBlock2 = $('<input>', {
                        id: 'soa-property-' + property.ID + '-2',
                        name: 'order[ORDER_PROP_' + property.ID + ']',
                        type: 'radio',
                        placeholder: property.NAME,
                        value: 'Юридическое лицо',
                        class: 'input-checkbox'
                    });

                    let labelBlockCheck1 = $('<label>', {
                        for: 'soa-property-' + property.ID + '-1',
                        text: 'ИП',
                        style: 'display: inline;'
                    });
                    let labelBlockCheck2 = $('<label>', {
                        for: 'soa-property-' + property.ID + '-2',
                        text: 'Юридическое лицо',
                        style: 'display: inline;'
                    });

                    labelBlock.appendTo(propBlock);
                    inputBlock.appendTo(propBlock);
                    labelBlockCheck1.appendTo(propBlock);
                    br.appendTo(propBlock);
                    inputBlock2.appendTo(propBlock);
                    labelBlockCheck2.appendTo(propBlock);

                    propBlock.appendTo($('#payment ul.wc_payment_methods.payment_methods.methods:first'));


                } else {

                    if (property.SIZE < 100) {
                        if (k % 2) {
                            propClass = 'form-row-first';
                        } else {
                            propClass = 'form-row-last';
                        }

                        k++;
                    } else {
                        propClass = 'form-row-wide';
                    }

                    let propBlock = $('<p>', {
                        class: 'form-row col-md-6 form-row validate-required ' + propClass
                    });

                    let labelBlock = $('<label>', {
                        for: 'soa-property-' + property.ID,
                        text: property.NAME + ' '
                    });

                    let inputBlock = $('<input>', {
                        id: 'soa-property-' + property.ID,
                        name: 'order[ORDER_PROP_' + property.ID + ']',
                        type: 'text',
                        placeholder: property.NAME,
                        value: property.VALUE[0],
                        class: 'input-text'
                    });

                    labelBlock.appendTo(propBlock);
                    inputBlock.appendTo(propBlock);

                    propBlock.appendTo($('#payment ul.wc_payment_methods.payment_methods.methods:first'));
                }
            } else {

                let locationInput = response.locations[property.ID]['output'][0];

                let labelBlock = $('<label>', {
                    for: 'soa-property-' + property.ID,
                    text: property.NAME + ' '
                });

                if (property.REQUIRED) {
                    $('<abbr>', {
                        title: 'обязательно',
                        class: 'required',
                        text: '*'
                    }).appendTo(labelBlock);
                }

                let propBlock = $('<p>', {
                    class: 'form-row form-row validate-required form-row-wide'
                });

                labelBlock.appendTo(propBlock);
                $(locationInput).appendTo(propBlock);

                propBlock.appendTo(resultBlock);

                // let promise = _this.getLocationProperty(property);
                //
                // let labelBlock = $('<label>', {
                //     for: 'soa-property-' + property.ID,
                //     text: property.NAME + ' '
                // });
                //
                // if (property.REQUIRED) {
                //     $('<abbr>', {
                //         title: 'обязательно',
                //         class: 'required',
                //         text: '*'
                //     }).appendTo(labelBlock);
                // }
                //
                // let propBlock = $('<p>', {
                //     class: 'form-row form-row validate-required form-row-wide'
                // });
                //
                // promise.then(result => {
                //     labelBlock.appendTo(propBlock);
                //     result.appendTo(propBlock);
                //     propBlock.appendTo(resultBlock);
                // });
            }
        });

        return resultBlock;
    }

    getServicesBlock(data, type = 'delivery') {

        let inputIdTemplate = (type == 'delivery') ? 'ID_DELIVERY_ID_' : 'ID_PAY_SYSTEM_ID_';
        let inputNameTemplate = (type == 'delivery') ? 'order[DELIVERY_ID]' : 'order[PAY_SYSTEM_ID]';
        let nameTemplate = (type == 'delivery') ? 'OWN_NAME' : 'NAME';

        let resultBlock = $('<ul>', {
            class: 'wc_payment_methods payment_methods methods'
        });

        let descriptionBlock;
        console.log(data)
        $.each(data, (i, service) => {

            let serviceBlock = $('<li>', {
                class: 'wc_payment_method payment_method_bacs',
                id: 'SERVIDE_BLOCK_' + service.ID,
            });

            let labelBlock = $('<label>', {
                for: inputIdTemplate + service.ID,
                text: service[nameTemplate] + (service.PRICE > 0 ? ' - ' + service.PRICE_FORMATED : '')
            });

            let inputBlock = $('<input>', {
                id: inputIdTemplate + service.ID,
                name: inputNameTemplate,
                type: 'radio',
                value: service.ID,
                class: 'input-radio'
            });

            if (typeof service.CHECKED !== 'undefined') {
                inputBlock.attr('checked', 'checked');
            }

            inputBlock.appendTo(serviceBlock);
            labelBlock.appendTo(serviceBlock);

            if (service.DESCRIPTION.length > 0) {
                descriptionBlock = $('<div>', {
                    class: 'payment_box payment_method_bacs',

                    append: $('<p>', {
                        html: service.DESCRIPTION
                    })
                });

                descriptionBlock.appendTo(serviceBlock);
            }

            serviceBlock.appendTo(resultBlock);
        });

        return resultBlock;
    }

    getLocationProperty(data) {
        return new Promise((resolve, reject) => {
            $.post('/local/ajax/order_location.php', data, (dataR) => {
                resolve($(dataR));
            });
        });
    }
}

export default Entities;
