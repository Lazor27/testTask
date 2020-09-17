class Form {
    constructor() {}

    static getValues(form) {
        let serialize = form.serializeArray(), values = {};

        for (let item of serialize) {
            if (item.value.length > 0) {
                values[item.name] = item.value;
            }
        }

        return values;
    }

    static getDecodeUrl(str) {
        return str.replace(/\&quot;/g, '"').replace(/&#39;/g, "'").replace(/\&lt;/g, '<').replace(/\&gt;/g, '>').replace(/\&amp;/g, '&').replace(/\&nbsp;/g, ' ');
    }
}

export default Form;
