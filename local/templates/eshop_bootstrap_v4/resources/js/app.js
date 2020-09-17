/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
|
*/

import './web/bootstrap';

import Router from './web/app/router';
import OrderController from "./web/common/controller/order-controller";

const router = new Router();

router.on('/personal/order/make/', contract => new OrderController(contract).order());
