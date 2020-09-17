import Request from '../services/http/request';
import PropertyManager from '../services/manager/property-manager';

class Model {
    constructor() {
        this.request = new Request();
        this.response = PropertyManager.setDynamic();
    }

    subscribe(data) {
        this.request.post(data.path, data.props, e => this.response.print = e.data);
    }

    get(data) {
        return new Promise((resolve, reject) => {
            this.request.post(data.path, data.props, e => resolve(e.data));
        });
    }

}

export default Model;
