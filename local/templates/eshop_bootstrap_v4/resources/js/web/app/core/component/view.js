import Seeds from '../services/storage/seeds';
import PropertyManager from '../services/manager/property-manager';

class View {
    constructor(data = {}) {
        this.seeds = new Seeds();
        this.request = PropertyManager.setDynamic();

        this.data = data;
        this.isTouch = !!$('html').hasClass('bx-touch');

        this.boot();
        this.set();
        this.event();
    }

    setSeed(seed, params = null) {
        return (params != null) ? this.seeds.constructor[seed](params) : this.seeds.constructor[seed]();
    }

    boot () {}

    set() {}

    event() {}

    rebuild() {}
}

export default View;
