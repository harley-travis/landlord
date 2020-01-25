<template>
    <!-- resources/assets/js/components -->
    <div>
        <canvas id="canvas"></canvas>
    </div>
</template>

<script>
    import {Chart} from 'Chart.js';
    export default {
        props: {
            labels: String,
            dataProp: String
        },
        methods: {
            renderChart() {
                new Chart(document.getElementById('canvas').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: JSON.parse(this.labels),
                        datasets: [{
                            label: "Total Earned",
                            data: JSON.parse(this.dataProp),
                            backgroundColor: [
                                '#2ecc71',
                            ]
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            fontSize: 22,
                            text: 'Total Revenue This Year'
                        }
                    }
                });
            }
        },
        mounted() {
            this.renderChart();
        }
    }
</script>