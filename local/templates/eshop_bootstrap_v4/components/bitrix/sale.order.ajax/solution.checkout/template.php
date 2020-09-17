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

//\Bitrix\Main\Diag\Debug::dump($arResult);
?>

<article id="post-3135" class="post-3135 page type-page status-publish hentry">


    <div style="display: none">
        <?
        // we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it
        $APPLICATION->IncludeComponent(
            'bitrix:sale.location.selector.steps',
            '.default',
            array(),
            false
        );
        $APPLICATION->IncludeComponent(
            'bitrix:sale.location.selector.search',
            '.default',
            array(),
            false
        );
        ?>
    </div>




    <?php if ($request->get('ORDER_ID')) : ?>
        <?php include($server->getDocumentRoot() . $templateFolder . '/success.php') ?>
    <?php else : ?>
    <form
            id="bx-soa-order-form"
            enctype="multipart/form-data"
            action="<?= $getRequestUri; ?>"
            class="checkout"
            name="ORDER_FORM"
            method="POST"

    >

        <?= bitrix_sessid_post(); ?>

        <input type="hidden" name="order[location_type]" value="code">
        <input type="hidden" name="SITE_ID" value="<?= SITE_ID; ?>">
        <input type="hidden" name="order[BUYER_STORE]" id="BUYER_STORE" value="<?= $arResult['BUYER_STORE']; ?>">
        <input type="hidden" name="order[PERSON_TYPE]" id="PERSON_TYPE" value="<?= $arResult['PERSON_TYPE_SELECTED']; ?>">
        <input type="hidden" name="order[ZIP_PROPERTY_CHANGED]" id="ZIP_PROPERTY_CHANGED" value="N">
        <?php if (count($arResult['PERSON_TYPE']) > 1) : ?>
            <?php foreach ($arResult['PERSON_TYPE'] as $personType) : ?>
                <?php if ($personType['CHECKED'] == 'Y') : ?>
                    <input type="hidden" name="order[PERSON_TYPE_OLD]" id="PERSON_TYPE_OLD" value="<?= $personType['ID']; ?>">
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <input type="hidden" name="signed_params_string" id="SIGNED_PARAMS_STRING" value="<?= $signedParams; ?>">

        <div id="customer_details" class="col2-set">
            <div class="col-12">
                <div class="woocommerce-billing-fields">

                    <h3><?= Loc::getMessage('BILLING_DETAILS'); ?></h3>

                    <div id="properties">
                        <?php foreach ($arResult['JS_DATA']['ORDER_PROP']['properties'] as $key => $prop) : ?>
                        <?php if ($prop['TYPE'] != 'LOCATION') : ?>
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
                        <p class="form-row form-row <?= $class; ?> validate-required">
                            <label for="soa-property-<?= $prop['ID']; ?>">
                                <?= $prop['NAME']; ?>&nbsp;
                                <?php if ($prop['REQUIRED'] == 'Y') : ?>
                                    <abbr title="<?= Loc::getMessage('REQUIRED_TITLE'); ?>" class="required">*</abbr>
                                <?php endif; ?>
                            </label>
                            <input
                                   id="soa-property-<?= $prop['ID']; ?>"
                                   name="order[ORDER_PROP_<?= $prop['ID']; ?>]"
                                   type="text"
                                   placeholder="<?= $prop['NAME']; ?>"
                                   value="<?= $prop['VALUE'][0]; ?>"
                                   class="input-text "
                            >
                        </p>
                        <?php else: ?>
                            LOCATION
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

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
                                        <?= $delivery['OWN_NAME']; ?><?= ($delivery['PRICE'] > 0) ? ' - '.$delivery['PRICE_FORMATED'] : ''; ?>
                                    </label>
                                    <?php if (!empty($delivery['DESCRIPTION'])) : ?>
                                        <div class="payment_box payment_method_bacs">
                                            <p><?= $delivery['DESCRIPTION']; ?></p>
                                        </div>
                                    <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                        <li class='customer-support menu-item menu-item-type-custom menu-item-object-custom'>

                        </li>
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
                            <th
                                class="<?= ($headerKey == (count($arResult['GRID']['HEADERS']) - 1)) ? 'product-total' : 'product-name'; ?>"
                                style="width: <?= ($headerKey == 0) ? '70' : 30/count($arResult['GRID']['HEADERS']) ?>%;"
                            >
                                <?= $header['name']; ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($arResult['GRID']['ROWS'] as $row) : ?>
                    <tr class="cart_item">
                        <?php foreach ($arResult['GRID']['HEADERS'] as $headerKey => $header) : ?>
                            <td
                                class="<?= ($headerKey == (count($arResult['GRID']['HEADERS']) - 1)) ? 'product-total' : 'product-name'; ?>"
                                style="width: <?= ($headerKey == 0) ? '70' : 30 / count($arResult['GRID']['HEADERS']) ?>%; <?= ($headerKey == (count($arResult['GRID']['HEADERS']) - 1)) ? 'text-align: right;' : ''; ?>"
                            >
                                <?= $row['data'][$header['id']]; ?>
<!--                                <strong class="product-quantity">× 1</strong>-->
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>

                    <tr class="order-total" style="border-top: 3px solid #ddd;">
                        <th><?= Loc::getMessage('ITEMS_TOTAL'); ?></th>
                        <td>
                            <strong>
                                <span class="amount"><?= $arResult['JS_DATA']['TOTAL']['ORDER_PRICE_FORMATED']; ?></span>
                            </strong>
                        </td>
                    </tr>
                    <tr class="order-total">
                        <th><?= Loc::getMessage('DELIVERY_TOTAL'); ?></th>
                        <td>
                            <strong>
                                <span class="amount" id="delivery_total_block"><?= $arResult['JS_DATA']['TOTAL']['DELIVERY_PRICE_FORMATED']; ?></span>
                            </strong>
                        </td>
                    </tr>
                    <tr class="order-total">
                        <th><?= Loc::getMessage('TOTAL'); ?></th>
                        <td>
                            <strong>
                                <span class="amount" id="order_total_block"><?= $arResult['JS_DATA']['TOTAL']['ORDER_TOTAL_PRICE_FORMATED']; ?></span>
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

                    <style>
                        .main-user-consent-request-popup-button.main-user-consent-request-popup-button-acc {
                            background: #fed700 !important;
                        }

                        .consent label {
                            margin: 15px 0 35px;
                        }
                    </style>


                    </div>

                    <input type="submit" data-value="Place order" value="<?= Loc::getMessage('PLACE_ORDER'); ?>" class="button alt">
                </div>
            </div>
        </div>
    </form>
    <?php endif; ?>
</article>
