import Axios from 'axios';
import qs from 'qs';

class Request {
    constructor(headers = {'X-Requested-With': 'XMLHttpRequest'}) {
        this.instance = Axios.create({headers: headers});
    }

    send(url, method, data, callback, responseType = 'json') {
        this.instance({url: url, method: method, data: qs.stringify(data), responseType: responseType}).then(function(e) {
            callback(e);
        });
    }

    get(url, data, callback) {
        this.instance.get(url, qs.stringify(data)).then(function(e) {
            callback(e);
        });
    }

    post(url, data, callback) {
        this.instance.post(url, qs.stringify(data)).then(function(response) {
            callback(response);
        });
    }

    lazy(url, data, callback, dataType = 'json') {
        $.ajax({
            url: url, type: 'post', data: data, dataType: dataType,
            success: function (response) {
                callback(response);
            },
        });
    }
}

export default Request;
