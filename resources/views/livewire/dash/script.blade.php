<script>
    document.addEventListener('livewire:load', function() {

        
        //-------------------------------------------------------------------------------------//
        //                        TOP 5 PRODUCTOS
        // ------------------------------------------------------------------------------------//
        var optionsTop = {
            series: [
                parseFloat(@this.top5Data[0]['total']),
                parseFloat(@this.top5Data[1]['total']),
                parseFloat(@this.top5Data[2]['total']),
                parseFloat(@this.top5Data[3]['total']),
                parseFloat(@this.top5Data[4]['total'])
            ],
            chart: {
                height: 392,
                type: 'donut',
            },
            labels: [@this.top5Data[0]['product'],
                @this.top5Data[1]['product'],
                @this.top5Data[2]['product'],
                @this.top5Data[3]['product'],
                @this.top5Data[4]['product']
            ],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chartTop = new ApexCharts(document.querySelector("#chartTop5"), optionsTop);
        chartTop.render();

         
       //-------------------------------------------------------------------------------------//
        //                                  WEEK SALES
        // ------------------------------------------------------------------------------------//
        var optionsArea = {
            chart: {
                height: 380,
                type: 'area',
                stacked: false,
            },
            stroke: {
                curve: 'straight'
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return '$' + parseFloat(val).toFixed(2);
                },
                offsetY: -5,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: "Day Sale",
                data: [
                    parseFloat(@this.weekSales_Data[0]),
                    parseFloat(@this.weekSales_Data[1]),
                    parseFloat(@this.weekSales_Data[2]),
                    parseFloat(@this.weekSales_Data[3]),
                    parseFloat(@this.weekSales_Data[4]),
                    parseFloat(@this.weekSales_Data[5]),
                    parseFloat(@this.weekSales_Data[6])
                ]
            }, ],
            xaxis: {
                categories: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            },
            tooltip: {
                followCursor: true
            },
            fill: {
                opacity: 1,
            },

        }

        var chartArea = new ApexCharts(
            document.querySelector("#chartArea"),
            optionsArea
        );

        chartArea.render();

        

    })
</script>
