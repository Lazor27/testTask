import Cultivator from '../storage/cultivator';

class EventManager {
    constructor() {

    }

    subscribe(view, model) {
        view.request.registerListener(data => model.subscribe(data));
        model.response.registerListener(data => view.rebuild(data));
    }
}

export default EventManager;
