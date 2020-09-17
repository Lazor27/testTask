<?php
/**
 * User: Zakhar Senenkov
 * Date: 04.07.2019 23:18
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;

$request = Context::getCurrent()->getRequest();
?>
<div class="text-center">
    <div class="capacity capacity-h3" style="text-align: center; margin-bottom: 1em; font-size: 2em;">
        <span><?= Loc::getMessage('SOA_ORDER_COMPLETE', ['ORDER_ID' => $request['ORDER_ID']]); ?></span>
    </div>
    <img src="<?= getPathImage('success-cart', 'svg'); ?>" alt="" width="250" height="250" style="margin: 0 auto;">
</div>

<script>
    <?
    $db_sales = CSaleBasket::GetList(['ID' => 'ASC'], ["ORDER_ID" => $arResult["ORDER"]['ID']]);
    while ($ar_sales = $db_sales->Fetch()){
        $purchaseGoogleItems[] = [
            'id' => $ar_sales['ID'],
            'name' => $ar_sales['NAME'],
            'price' => $ar_sales['PRICE'],
            'quantity' => $ar_sales['QUANTITY']
        ];
    }
    $purchaseArray = [
        'transaction_id' => $arResult["ORDER"]["ID"],
        'affiliation' => getConstant('PROJECT_NAME'),
        'currency' => getConstant('CURRENCY_ID'),
        'value' => $arResult["ORDER"]["PRICE"],
        'items' => $purchaseGoogleItems,
    ]?>

    <?php $gaOutput[] = "gtag('event', 'purchase', " . json_encode($purchaseArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . ");";?>
    <?=$gaOutput[0]?>
</script>

