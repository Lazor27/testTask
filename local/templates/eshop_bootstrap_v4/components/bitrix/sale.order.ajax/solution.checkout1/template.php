<?php
/**
 * Created by PhpStorm.
 * User: vladposhvanyk
 * Date: 6/19/19
 * Time: 9:22 PM
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Security\Sign\Signer;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;

Loc::loadMessages(__FILE__);
$langMess = Loc::loadLanguageFile(__FILE__);

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$server = $context->getServer();
$getRequestUri = $request->getRequestUri();

$signer = new Signer;
$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');

$i = 0;
?>

<article id="post-3135" class="post-3135 page type-page status-publish hentry">

    <header class="entry-header">
        <h1 class="entry-title"><?= Loc::getMessage('TITLE'); ?></h1>
    </header>
    <?php if ($request->get('ORDER_ID')) : ?>
        <?php include($server->getDocumentRoot() . $templateFolder . '/success.php') ?>
    <?php else : ?>
    <form
            id="bx-soa-order-form"
            enctype="multipart/form-data"
            action="<?= $getRequestUri; ?>"
            class="checkout woocommerce-checkout"
            name="ORDER_FORM"
            method="POST"
    >

        <?= bitrix_sessid_post(); ?>
        <input type="hidden" name="<?= $arParams['ACTION_VARIABLE']; ?>" value="saveOrderAjax">
        <input type="hidden" name="order[location_type]" value="code">
        <input type="hidden" name="SITE_ID" value="<?= SITE_ID; ?>">
        <input type="hidden" name="order[BUYER_STORE]" id="BUYER_STORE" value="<?= $arResult['BUYER_STORE']; ?>">
        <input type="hidden" name="order[PERSON_TYPE]" id="PERSON_TYPE" value="<?= $arResult['PERSON_TYPE_SELECTED']; ?>">
        <input type="hidden" name="signed_params_string" id="SIGNED_PARAMS_STRING" value="<?= $signedParams; ?>">

        <div id="customer_details" class="col2-set">
            <div class="col-1">
                <div class="woocommerce-billing-fields">

                    <h3><?= Loc::getMessage('BILLING_DETAILS'); ?></h3>

                    <?php foreach ($arResult['JS_DATA']['ORDER_PROP']['properties'] as $key => $prop) : ?>
                    <?php
                        if ($prop['SIZE'] < 100) {
                            if ($i % 2) {
                                $class = 'form-row-last';
                            } else {
                                $class = 'form-row-first';
                            }

                            $i++;
                        } else {
                            $class = 'form-row-wide';
                        }
                    ?>
                    <p id="billing_first_name_field" class="form-row form-row <?= $class; ?> validate-required">
                        <label class="" for="soa-property-<?= $prop['ID']; ?>">
                            <?= $prop['NAME']; ?>
                            <?php if ($prop['REQUIRED'] == 'Y') : ?>
                                <abbr title="required" class="required">*</abbr>
                            <?php endif; ?>
                        </label>
                        <input
                               id="soa-property-<?= $prop['ID']; ?>"
                               name="order[ORDER_PROP_<?= $prop['ID']; ?>]"
                               type="text"
                               placeholder="<?= $prop['NAME']; ?>"
                               value="<?= $prop['VALUE'][0]; ?>"
                               class="input-text ">
                    </p>
                    <?php endforeach; ?>

                   <div class="clear"></div>

                </div>
            </div>

            <div class="col-2">
                <h3><?= Loc::getMessage('SHIPPING_DETAILS'); ?></h3>

                <div class="woocommerce-shipping-fields">
<!--                    <h3 id="ship-to-different-address">-->
<!--                        <label class="checkbox" for="ship-to-different-address-checkbox">Ship to a different address?</label>-->
<!--                        <input type="checkbox" value="1" name="ship_to_different_address" class="input-checkbox" id="ship-to-different-address-checkbox">-->
<!--                    </h3>-->

                    <p id="order_comments_field" class="form-row form-row notes">
                        <label class="" for="orderDescription"><?= Loc::getMessage('COMMENT_ORDER_TITLE'); ?></label>
                        <textarea
                            cols="5" rows="2"
                            class="input-text "
                            id="orderDescription"
                            name="order[ORDER_DESCRIPTION]"
                            placeholder="<?= Loc::getMessage('COMMENT_ORDER'); ?>"
                            style="height: 100px;"
                        ></textarea>
                    </p>

                </div>

                <div class="woocommerce-checkout-payment" id="delivery">
                    <ul class="wc_payment_methods payment_methods methods">
                        <?php foreach ($arResult['DELIVERY'] as $key => $delivery) : ?>
                            <li class="wc_payment_method payment_method_bacs">
                                    <input
                                            id="ID_DELIVERY_ID_<?= $delivery['ID']; ?>"
                                            class="input-radio"
                                            name="order[DELIVERY_ID]"
                                            type="radio"
                                            value="<?= $delivery['ID']; ?>"
                                        <?= $delivery['CHECKED'] == 'Y' ? 'checked' : ''; ?>
                                    />
                                    <label for="ID_DELIVERY_ID_<?= $delivery['ID']; ?>">
                                        <?= $delivery['NAME']; ?><?= ($delivery['PRICE'] > 0) ? ' - '.$delivery['PRICE_FORMATED'] : ''; ?>
                                    </label>
                                    <?php if (!empty($delivery['DESCRIPTION'])) : ?>
                                        <div class="payment_box payment_method_bacs">
                                            <p><?= $delivery['DESCRIPTION']; ?></p>
                                        </div>
                                    <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <h3 id="order_review_heading"><?= Loc::getMessage('YOUR_ORDER'); ?></h3>

        <div class="woocommerce-checkout-review-order" id="order_review" style="margin: 0 auto; width: 100%;">
            <table class="shop_table woocommerce-checkout-review-order-table">
                <thead>
                    <tr>
                        <?php foreach ($arResult['GRID']['HEADERS'] as $headerKey => $header) : ?>
                            <th class="<?= ($headerKey == (count($arResult['GRID']['HEADERS']) - 1)) ? 'product-total' : 'product-name'; ?>"><?= $header['name']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($arResult['GRID']['ROWS'] as $row) : ?>
                    <tr class="cart_item">
                        <?php foreach ($arResult['GRID']['HEADERS'] as $headerKey => $header) : ?>
                            <td class="<?= ($headerKey == (count($arResult['GRID']['HEADERS']) - 1)) ? 'product-total' : 'product-name'; ?>">
                                <?= $row['data'][$header['id']]; ?>
<!--                                <strong class="product-quantity">× 1</strong>-->
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
<!--                    <tr class="cart-subtotal">-->
<!--                        <th>Subtotal</th>-->
<!--                        <td><span class="amount">$3,299.00</span></td>-->
<!--                    </tr>-->
<!---->
<!--                    <tr class="shipping">-->
<!--                        <th>Shipping</th>-->
<!--                        <td data-title="Shipping">-->
<!--                            Flat Rate: <span class="amount">$300.00</span>-->
<!--                            <input type="hidden" class="shipping_method" value="international_delivery" id="shipping_method_0" data-index="0" name="shipping_method[0]">-->
<!--                        </td>-->
<!--                    </tr>-->

                    <tr class="order-total">
                        <th><?= Loc::getMessage('TOTAL'); ?></th>
                        <td>
                            <strong>
                                <span class="amount"><?= $arResult['JS_DATA']['TOTAL']['ORDER_PRICE_FORMATED']; ?></span>
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="woocommerce-checkout-payment" id="payment">
                <ul class="wc_payment_methods payment_methods methods">
                    <?php foreach ($arResult['PAY_SYSTEM'] as $key => $paySystem) : ?>
                        <li class="wc_payment_method payment_method_bacs">
                            <input
                                    id="ID_PAY_SYSTEM_ID_<?= $paySystem['ID']; ?>"
                                    name="order[PAY_SYSTEM_ID]"
                                    type="radio"
                                    value="<?= $paySystem['ID']; ?>"
                                    class="input-radio"
                                <?= $paySystem['CHECKED'] == 'Y' ? 'checked' : ''; ?>
                            />
                            <label for="ID_PAY_SYSTEM_ID_<?= $paySystem['ID']; ?>"><?= $paySystem['NAME']; ?></label>
                            <?php if (!empty($paySystem['DESCRIPTION'])) : ?>
                                <div class="payment_box payment_method_bacs">
                                    <p><?= $paySystem['DESCRIPTION']; ?></p>
                                </div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="form-row place-order">

<!--                    <p class="form-row terms wc-terms-and-conditions">-->
<!--                        <input type="checkbox" id="terms" name="terms" class="input-checkbox">-->
<!--                        <label class="checkbox" for="terms">I’ve read and accept the <a target="_blank" href="terms-and-conditions.html">terms &amp; conditions</a> <span class="required">*</span></label>-->
<!--                        <input type="hidden" value="1" name="terms-field">-->
<!--                    </p>-->

                    <input type="submit" data-value="Place order" value="<?= Loc::getMessage('PLACE_ORDER'); ?>" class="button alt">
                </div>
            </div>
        </div>
    </form>
    <?php endif; ?>
</article>
