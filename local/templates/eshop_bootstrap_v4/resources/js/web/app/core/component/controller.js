import EventManager from '../services/manager/event-manager';

class Controller {
    constructor(contract = {}) {
        this.eventManager = new EventManager();
        this.contract = contract;
        this.boot();
    }

    boot() { }
}

export default Controller;
