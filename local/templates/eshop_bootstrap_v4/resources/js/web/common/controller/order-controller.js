import Controller from '../../app/core/component/controller';
import Order from '../view/layout/order/order';
import ObserverModel from '../model/observer-model';

class PageController extends Controller {
   order () {
        const orderView = new Order();

        this.eventManager.subscribe(orderView, new ObserverModel());
   }
}

export default PageController;