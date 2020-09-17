<?php
/**
 * User: Zakhar Senenkov
 * Date: 12.07.2019 16:52
 */

header('Content-type: application/json');

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    return;
}

define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC', 'Y');
define('DisableEventsCheck', true);
define('BX_SECURITY_SHOW_MESSAGE', true);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Sale\Fuser;
use Bitrix\Main\Web\Json;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;

Loader::includeModule('sale');

$userId = $_SESSION['SESS_AUTH']['USER_ID'];
$result = [];

$basket = \Bitrix\Sale\Basket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());

foreach ($basket->getBasketItems() as $item) {
    $returnItems[] = $item->getProductId();
}

$result['success'] = [
    'get' => true,
    'products' => $returnItems
];


echo Json::encode($result);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');
