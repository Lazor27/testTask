class PropertyManager {
    static setDynamic() {
        return {
            aInternal: 10,
            aListener: (val) => {},
            set print(val) {
                this.aInternal = val;
                this.aListener(val);
            },
            get print() {
                return this.aInternal;
            },
            registerListener: function (listener) {
                this.aListener = listener;
            }
        }
    }
}

export default PropertyManager;
