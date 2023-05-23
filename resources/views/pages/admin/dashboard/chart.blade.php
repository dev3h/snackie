<figure class="highcharts-figure">
    <div id="container-1"></div>
</figure>

<script src="{{ asset('backend/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var day = 7;
        $.ajax({
                url: "{{ route('admin.get_revenue') }}",
                dataType: "json",
                data: {
                    days: day
                },
            })
            .done(function(response) {
                const arrX = Object.keys(response);
                const arrY = Object.values(response);

                Highcharts.chart("container-1", {
                    title: {
                        text: `Thống kế doanh thu ${day} ngày gần nhất`,
                    },

                    yAxis: {
                        title: {
                            text: "Doanh thu",
                        },
                    },

                    xAxis: {
                        categories: arrX
                    },

                    legend: {
                        layout: "vertical",
                        align: "right",
                        verticalAlign: "middle",
                    },

                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false,
                            },
                        },
                    },

                    series: [{
                        name: "Doanh thu",
                        data: arrY
                    }, ],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500,
                            },
                            chartOptions: {
                                legend: {
                                    layout: "horizontal",
                                    align: "center",
                                    verticalAlign: "bottom",
                                },
                            },
                        }, ],
                    },
                });
            })
    });
</script>
