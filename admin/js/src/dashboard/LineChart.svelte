<script>
    import Chart from 'chart.js';
    import { v4 as generateUUID } from 'uuid';
    import { afterUpdate, onMount } from 'svelte';

    export let data;
    export let dataLabel;
    export let dataColor;
    export let dataAxisLabel;

    window.addEventListener('resize', setCanvasWidth, false);

    let uuid = generateUUID();
    let myChart;

    const colors = {
        blue: 'rgba(54, 162, 235, 0.2)',
        red: 'rgba(255, 99, 132, 0.2)',
        yellow: 'rgba(255, 206, 86, 0.2)',
        green: 'rgba(75, 192, 192, 0.2)'
    };

    function setCanvasWidth() {
        if (document) {
            const canvas = document.getElementById(uuid);
            if (canvas && canvas.parentElement) {
                const parent = canvas.parentElement;
                canvas.width = parent.offsetWidth - 60;
            }
        }
    }

    function updateChart() {
        setCanvasWidth();
        if (document) {
            const canvas = document.getElementById(uuid);
            if (canvas) {
                myChart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: data.map(d => ''/*parseISO(d.lastCheck)*/),
                        legend: { display: false },
                        datasets: [{
                            label: dataLabel,
                            data: data.map(d => d.time),
                            borderWidth: 1,
                            backgroundColor: [colors[dataColor]],
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        scales: {
                            xAxes: [{
                                display: false
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: dataAxisLabel
                                }
                            }]
                        }
                    }
                });
            }
        }
    }

    afterUpdate(() => {
        if (data.length > 0) {
            updateChart();
        }
    });

    onMount(() => {
        if (data.length > 0) {
            updateChart();
        }
    });

    function showCanvas() {
        return data.length > 0;
    }
</script>

<style></style>

{#if showCanvas()}
    <canvas id="{uuid}" height="300"></canvas>
{:else}
    There is currently no data available. It can take up to 5 minutes to initially populate this data.
{/if}