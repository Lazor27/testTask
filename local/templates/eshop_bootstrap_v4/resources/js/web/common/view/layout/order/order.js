import View from '../../../../app/core/component/view';

import Provider from '../../../../app/core/services/http/provider';
import Entities from './entities';

import * as mask from "jquery.maskedinput/src/jquery.maskedinput";

class Order extends View {
    boot() {
        this.locationInput = '7';
        this.location = '[name="ORDER_PROP_7"]'

        this.form = '#bx-soa-order-form';
        this.deliveryMainBlock = '#delivery';
        this.paymentMainBlock = '#payment';
        this.propsMainBlock = '#properties';
        this.total = {
            delivery: '#delivery_total_block',
            order: '#order_total_block'
        };

        this.jForm = $(this.form);
        this.jDeliveryMainBlock = $(this.deliveryMainBlock);
        this.jPaymentMainBlock = $(this.paymentMainBlock);
        this.jPropsMainBlock = $(this.propsMainBlock);
        this.jTotal = {
            delivery: $(this.total.delivery),
            order: $(this.total.order)
        };

        this.orderEntites = new Entities();


        this.personTypeInput = '#PERSON_TYPE';
        this.personTypeOldInput = '#PERSON_TYPE_OLD';



        if ($(this.personTypeInput).length > 0) {
            $(this.personTypeInput).val($('li[data-code="FIZ_' + $('li[data-current-price]').data('current-price') + '"]').data('id'));
            $(this.personTypeInput).trigger('change');

            this.orderAction = 'refreshOrderAjax';

            let _this = this;

            $.post(
                this.eventData(this.jForm).path,
                this.eventData(this.jForm).props,
                function (response) {
                    _this.rebuild(response);
                    _this.orderAction = '';
                    $('#post-3135 form').show();
                }
            );
        }
    }

    event() {
        this.jForm.on('submit', (element) => this.afterEvent(element));
        this.jForm.delegate('[id^=ID_DELIVERY_]', 'change', (element) => this.rebuildEvent(element));
        this.jForm.delegate('[id^=ID_PAY_SYSTEM_ID_]', 'change', (element) => this.rebuildEvent(element));
        $(document).on('click', '.dropdown-item.bx-ui-sls-variant',  (element) => this.rebuildEvent(element));

    }

    serializeOrder(formData) {
        let order = {},
            data = {};

        data['order'] = {};
        data['via_ajax'] = 'Y';
        data['soa-action'] = this.orderAction;

        for (let i = 0; i < formData.length; i++) {
            let curInputName = formData[i].name;
            if (curInputName.indexOf('order[') !== -1) {
                curInputName = curInputName.replace(/order\[|\]/gi, '');
                data['order'][curInputName] = formData[i].value;
                data[curInputName] = formData[i].value;
            } else {
                if (curInputName == 'ORDER_PROP_' + this.locationInput) {
                    data['order'][curInputName] = formData[i].value;
                    data[curInputName] = formData[i].value;
                } else {
                    data[curInputName] = formData[i].value;
                }
            }
        }

        return data;
    }

    afterEvent(element) {
        element.preventDefault();

        let jForm = $(element.currentTarget);

        this.orderAction = 'saveOrderAjax';


            this.request.print = this.eventData(jForm);


        return false;
    }

    rebuildEvent() {

        this.orderAction = 'refreshOrderAjax';

        let jForm = $(this.form);

        this.request.print = this.eventData(jForm);
    }

    rebuild(response) {
        switch (this.orderAction) {
            case 'saveOrderAjax':
                if (typeof response.order.ERROR === 'undefined') {
                    Provider.redirect(response.order.REDIRECT_URL);
                } else {
                    this.showError(response.order.ERROR.PROPERTY);
                    this.scrollToTitle();
                }
                break;

            case 'refreshOrderAjax':

                let deliveries = [];
                let paysystems = [];
                let _this = this;
                let key;

                for (key in response.locations) {
                    _this.locationInput = key;
                }

                $.each(response.order.PERSON_TYPE, (i, type) => {
                    if (typeof type.CHECKED !== 'undefined') {
                        $(_this.personTypeOldInput).val(type.ID);
                    }
                });

                let checkedDelivery = [];

                for (let delivery in response.order.DELIVERY) {
                    if(response.order.DELIVERY[delivery].CHECKED == 'Y')
                        checkedDelivery = response.order.DELIVERY[delivery];
                    deliveries.push(response.order.DELIVERY[delivery]);
                }

                for (let paysystem in response.order['PAY_SYSTEM']) {
                    paysystems.push(response.order['PAY_SYSTEM'][paysystem]);
                }

                deliveries.sort(function (a, b) {
                    if (a.SORT > b.SORT) {
                        return 1;
                    }

                    if (a.SORT < b.SORT) {
                        return -1;
                    }

                    if (a.SORT == b.SORT) {
                        return 0;
                    }
                });

                paysystems.sort(function (a, b) {
                    if (a.SORT > b.SORT) {
                        return 1;
                    }

                    if (a.SORT < b.SORT) {
                        return -1;
                    }

                    if (a.SORT == b.SORT) {
                        return 0;
                    }
                });

                this.jDeliveryMainBlock.html(this.orderEntites.getServicesBlock(deliveries, 'delivery'));
                this.jPaymentMainBlock.find('ul:first').html(this.orderEntites.getServicesBlock(paysystems, 'paysystem'));

                this.jPropsMainBlock.html(this.orderEntites.getPropertiesBlock(response.order['ORDER_PROP'].properties, response));

                this.jTotal.delivery.html(response.order.TOTAL['DELIVERY_PRICE_FORMATED']);
                this.jTotal.order.html(response.order.TOTAL['ORDER_TOTAL_PRICE_FORMATED']);

                $('#soa-property-3').mask('+38(999)9999999');

                let k;
                    // first, init all controls
                    if(typeof window.BX.locationsDeferred != 'undefined'){

                        this.BXCallAllowed = false;

                        for(k in window.BX.locationsDeferred){

                            window.BX.locationsDeferred[k].call(this);
                            window.BX.locationsDeferred[k] = null;
                            delete(window.BX.locationsDeferred[k]);

                        }
                    }

                break;
        }
    }

    showError(errors) {
        let errorsToShow = '', i = 1;

        for (let error of errors) {
            errorsToShow += `<p>${i}. ${error}</p>`;
            i++;
        }

        new Alert({
            type: 'error',
            target: this.jForm,
            value: errorsToShow,
            time: 10,
            animate: true,
        });
    }

    scrollToTitle() {
        $('html, body').animate({'scrollTop': $('h1').offset().top}, 300);
    }

    eventData(jForm) {
        return {
            props: this.serializeOrder(jForm.serializeArray()),
            path: jForm.attr('action')
        }
    }
}


export default Order;
