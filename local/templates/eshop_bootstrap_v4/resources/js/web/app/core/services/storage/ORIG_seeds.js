class Seeds {
    static productGallerySingle() {
        return {
            items: 1,
            margin: 0,
            dots: false,
            nav: false,
            responsive:{
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 1
                },
            }
        }
    }

    static productGalleryAll() {
        return {
            items: 5,
            margin: 8,
            dots: false,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 3
                },
                768: {
                    items: 5
                },
            }
        }
    }

    static mainPageSlider() {
        return {
            items: 1,
            loop: true,
            autoplay: true,
            dots: true,
            dotsContainer: '.tp-bullets',
            nav: false,
            responsive: {
                768: {
                    items: 1,
                },
                480: {
                    items: 1,
                }
            }
        }
    }

    static rangePrice(params = {min: 0, max: 999, startMin: 0, startMax: 999}) {
        return {
            start: [params.startMin, params.startMax],
            step: 1,
            connect: true,
            range: {
                'min': params.min,
                'max': params.max
            }
        }
    }

    static overlayStyles(params = {show: false}) {
        return params.show ? {'opacity': '.6'} : {'opacity': '0'};
    }
}

export default Seeds;
