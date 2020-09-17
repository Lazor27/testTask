class Provider {
    constructor() {}

    static redirect(url, isSaveHistory = true) {
        if (url.length > 0) {
            (isSaveHistory) ? window.location.assign(url) : window.location.replace(url);
        }
    }
}

export default Provider;
