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
            autoHeight: true,
            autoHeightClass: 'owl-height',
            responsive: {
                768: {
                    items: 1,
                    autoHeight: true
                },
                480: {
                    items: 1,
                    autoHeight: true
                }

            }
        }
    }
    static sectionSlider() {
        return {
            items: 0,
            loop: true,
            autoplay: true,
            dots: true,
            dotsContainer: '.tp-bullets',
            nav: true,
            autoHeight: true,
            autoHeightClass: 'owl-height',
            responsive: {
                768: {
                    items: 1,
                    autoHeight: true
                },
                480: {
                    items: 1,
                    autoHeight: true
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
     static datepickerRuLang() {
            return {
                closeText: 'Закрыть',
                prevText: '&#x3C;Пред',
                nextText: 'След&#x3E;',
                currentText: 'Сегодня',
                monthNames: [ 'Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь' ],
                monthNamesShort: [ 'Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек' ],
                dayNames: [ 'воскресенье','понедельник','вторник','среда','четверг','пятница','суббота' ],
                dayNamesShort: [ 'вск','пнд','втр','срд','чтв','птн','сбт' ],
                dayNamesMin: [ 'Вс','Пн','Вт','Ср','Чт','Пт','Сб' ],
                weekHeader: 'Нед',
                dateFormat: 'dd.mm.yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
        }
}

export default Seeds;
