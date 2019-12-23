<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 11/13/2019 9:54 AM
 */
?>


<section class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div id="bar-chart"></div>
        </div>

        <div class="col-md-8">
            <div id="line-chart"></div>
        </div>

        <div class="col-md-8">
            <div id="area-chart"></div>
        </div>

        <div class="col-md-4">
            <div id="donut-chart"></div>
        </div>

        <div class="col-md-8">
            <div id="pie-chart"></div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        barChart();
        lineChart();
        areaChart();
        donutChart();

        $(window).resize(function () {
            window.barChart.redraw();
            window.lineChart.redraw();
            window.areaChart.redraw();
            window.donutChart.redraw();
        });
    });

    function barChart() {
        window.barChart = Morris.Bar({
            element: 'bar-chart',
            data: [
                {y: '2006', a: 100, b: 90},
                {y: '2007', a: 75, b: 65},
                {y: '2008', a: 50, b: 40},
                {y: '2009', a: 75, b: 65},
                {y: '2010', a: 50, b: 40},
                {y: '2011', a: 75, b: 65},
                {y: '2012', a: 100, b: 90}
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Series A', 'Series B'],
            lineColors: ['#1e88e5', '#ff3321'],
            lineWidth: '3px',
            resize: true,
            redraw: true
        });
    }

    function lineChart() {
        window.lineChart = Morris.Line({
            element: 'line-chart',
            data: [
                {y: '2006', a: 100, b: 90},
                {y: '2007', a: 75, b: 65},
                {y: '2008', a: 50, b: 40},
                {y: '2009', a: 75, b: 65},
                {y: '2010', a: 50, b: 40},
                {y: '2011', a: 75, b: 65},
                {y: '2012', a: 100, b: 90}
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Series A', 'Series B'],
            lineColors: ['#1e88e5', '#ff3321'],
            lineWidth: '3px',
            resize: true,
            redraw: true
        });
    }

    function areaChart() {
        window.areaChart = Morris.Area({
            element: 'area-chart',
            data: [
                {y: '2006', a: 100, b: 90},
                {y: '2007', a: 75, b: 65},
                {y: '2008', a: 50, b: 40},
                {y: '2009', a: 75, b: 65},
                {y: '2010', a: 50, b: 40},
                {y: '2011', a: 75, b: 65},
                {y: '2012', a: 100, b: 90}
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Series A', 'Series B'],
            lineColors: ['#1e88e5', '#ff3321'],
            lineWidth: '3px',
            resize: true,
            redraw: true
        });
    }

    function donutChart() {
        window.donutChart = Morris.Donut({
            element: 'donut-chart',
            data: [
                {label: "Download Sales", value: 50},
                {label: "In-Store Sales", value: 25},
                {label: "Mail-Order Sales", value: 5},
                {label: "Uploaded Sales", value: 10},
                {label: "Video Sales", value: 10}
            ],
            resize: true,
            redraw: true
        });
    }

    function pieChart() {
        var paper = Raphael("pie-chart");
        paper.piechart(
            100, // pie center x coordinate
            100, // pie center y coordinate
            90,  // pie radius
            [18.373, 18.686, 2.867, 23.991, 9.592, 0.213], // values
            {
                legend: ["Windows/Windows Live", "Server/Tools", "Online Services", "Business", "Entertainment/Devices", "Unallocated/Other"]
            }
        );
    }
</script>
