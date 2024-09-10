(function(window, document, $, undefined) {
    "use strict";
    $(function() {

        if ($('#c3chart_pie').length) {
            var chart = c3.generate({
                bindto: "#c3chart_pie",
                data: {
                    columns: [
                        ['completed', 30],
                        ['inactive', 20],
                        ['active', 50]
                    ],
                    type: 'pie',

                    colors: {
                        active: 'red',
                        inactive: 'orange',
                        completed: 'green'
                        


                    }
                },
                pie: {
                    label: {
                        format: function(value, ratio, id) {
                            return d3.format('')(value) + "%";
                        }
                    }
                }
            });
        }


        if ($('#c3chart_pie1').length) {
            var chart = c3.generate({
                bindto: "#c3chart_pie1",
                data: {
                    columns: [
                        ['completed', 30],
                        ['inactive', 20],
                        ['active', 50]
                    ],
                    type: 'pie',

                    colors: {
                        active: 'red',
                        inactive: 'orange',
                        completed: 'green'
                        


                    }
                },
                pie: {
                    label: {
                        format: function(value, ratio, id) {
                            return d3.format('')(value) + "%";
                        }
                    }
                }
            });
        }


        if ($('#c3chart_pie2').length) {
            var chart = c3.generate({
                bindto: "#c3chart_pie2",
                data: {
                    columns: [
                        ['completed', 30],
                        ['inactive', 20],
                        ['active', 50]
                    ],
                    type: 'pie',

                    colors: {
                        active: 'red',
                        inactive: 'orange',
                        completed: 'green'
                        


                    }
                },
                pie: {
                    label: {
                        format: function(value, ratio, id) {
                            return d3.format('')(value) + "%";
                        }
                    }
                }
            });
        }

        


    });

})(window, document, window.jQuery);