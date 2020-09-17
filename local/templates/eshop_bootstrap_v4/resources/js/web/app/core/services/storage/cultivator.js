class Cultivator {
    static getLastElement(array) {
        return array[array.length - 1];
    }

    static getLastKey(array) {
        return array.length - 1;
    }

    static getKeyByValue(value, array) {
        return parseInt(Object.keys(array).find(key => array[key] === value));
    }

    static getKeys(array) {
        return Object.keys(array).length;
    }
}

export default Cultivator;
