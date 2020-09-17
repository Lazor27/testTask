import Cultivator from './core/services/storage/cultivator';

class Router {
    constructor() {
        this.url = new URL(location.href);
        this.pathname = this.url.pathname;

        this.reSearchPath = /[\/.]/;
        this.reExpressionElement = /:/;
        this.expressionForAll = '*';
        this.special = ':params:';
    }

    on(path, callback) {
        let isSamePath, contract, isContract;

        isSamePath = (this.pathname === path);
        contract = (isSamePath) ? {} : this.getContract(path);
        isContract = (isSamePath === true || Object.keys(contract).length > 0 || this.expressionForAll === path);

        if (isContract) {
            callback(Object.assign({url: this.url}, contract));
        }
    }

    getValueResponse(searchPath, currentPath) {
        let response = {};

        if (
            searchPath[0] === currentPath[0]
            && Cultivator.getLastElement(searchPath) === Cultivator.getLastElement(currentPath)
        ) {
            let expression;

            searchPath.find((element, key) => {
                if (!currentPath.includes(element)) {
                    expression = element.split(this.reExpressionElement).filter(value => value !== "")[0];
                    response[expression] = currentPath[key];
                }
            });
        }

        return response;
    }

    getValueSpecial(searchPath, currentPath) {
        let keySpecial = Cultivator.getKeyByValue(this.special, searchPath);
        let begin = Cultivator.getKeyByValue(searchPath[keySpecial - 1], currentPath);
        let finish = Cultivator.getKeyByValue(searchPath[keySpecial + 1], currentPath);
        let params = [];

        for (let key in currentPath) {
            if (key > begin && key < finish) {
                params.push(currentPath[key]);
            }
        }

        return {
            searchPath: searchPath.filter(element => element !== this.special),
            currentPath: currentPath.filter(element => !params.includes(element)),
            params: params
        }
    }

    getFilterPath(path) {
        let ready = path.split(this.reSearchPath).filter((element, key) => key !== 0);

        if (ready[ready.length - 1] === "") {
            ready[ready.length - 1] = '/';
        }

        return ready;
    }

    getContract(path) {
        let contract = {};
        let special = {};
        let searchPath = this.getFilterPath(path);
        let currentPath = this.getFilterPath(this.pathname);

        if (searchPath.includes(this.special)) {
            special = this.getValueSpecial(searchPath, currentPath);

            if (special.searchPath.length === special.currentPath.length) {
                contract = this.getValueResponse(special.searchPath, special.currentPath);

                if (Object.keys(contract).length > 0) {
                    contract = Object.assign(contract, {params: special.params});
                }
            }
        } else {
            if (searchPath.length === currentPath.length) {
                contract = this.getValueResponse(searchPath, currentPath);
            }
        }

        return contract;
    }
}

export default Router;
