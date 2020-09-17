import EventManager from '../manager/event-manager';

class ServiceProvider {
    constructor() {
        this.boot();
        this.eventManager = new EventManager();
    }

    boot() { }
}

export default ServiceProvider;
