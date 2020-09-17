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
<?php

$arOrder = CSaleOrder::GetByID($arResult['ORDER']['ID']);
$priceOfOrder = 0;
$dbBasketItems = CSaleBasket::GetList(array(), array("ORDER_ID" => $arResult['ORDER']['ID']), false, false, array());
while ($arItems = $dbBasketItems->Fetch()) {
    $products[] = $arItems;
    $priceOfOrder += $arItems['PRICE'] * $arItems['QUANTITY'];

}
?>
<?php if($_COOKIE[$_GET['ORDER_ID']] !== 'Y'):?>
<script>
    gtag('event', 'purchase', {
        "transaction_id": "<?=$arResult['ORDER']['ID']?>",
        "affiliation": "Fissman",
        "value": "<?=$arOrder['PRICE']?>",
        "currency": "UAH",
        "shipping": "<?=$arOrder['PRICE_DELIVERY']?>",
        "items": [
            <?php foreach ($products as $product):?>
            {
                "id": "<?=$product['ID']?>",
                "name": "<?=$product['NAME']?>",
                "price": <?=round($product['PRICE'], 2)?>,
                "quantity": <?=$product['QUANTITY']?>
            },
            <?endforeach;?>
        ]
    });

</script>
<?php  setcookie($_GET['ORDER_ID'] , 'Y', time()+604800);?>
<?php endif;?>

