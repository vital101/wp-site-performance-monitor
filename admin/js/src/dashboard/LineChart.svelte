<script>
    import Chart from 'chart.js';
    import { v4 as generateUUID } from 'uuid';
    import { parseISO, format } from 'date-fns';
    import { afterUpdate, onMount } from 'svelte';

    export let data;
    export let dataLabel;
    export let dataColor;
    export let dataAxisLabel;

    let uuid = generateUUID();

    const colors = {
        blue: 'rgba(54, 162, 235, 0.2)',
        red: 'rgba(255, 99, 132, 0.2)',
        yellow: 'rgba(255, 206, 86, 0.2)',
        green: 'rgba(75, 192, 192, 0.2)'
    };

    function updateChart() {
        if (document) {
            const canvas = document.getElementById(uuid);
            if (canvas) {
                const labelsModifier = Math.floor(data.length / 5);
                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: data.map(d => format(parseISO(d.lastCheck), 'LLL d @ hh:mm a')),
                        legend: { display: false },
                        datasets: [{
                            label: dataLabel,
                            data: data.map(d => d.time),
                            borderWidth: 1,
                            backgroundColor: [colors[dataColor]],
                            pointRadius: 0,
                            pointHitRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        tooltips: {
                            callbacks: {
                                label: tooltipItem => {
                                    return `${tooltipItem.yLabel}ms`;
                                },
                                title: tooltipItem => {
                                    return tooltipItem[0].label;
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    autoSkip: false,
                                    source: 'labels',
                                    callback: (value, index) => {
                                        if (index % labelsModifier === 0) {
                                            return value;
                                        } else {
                                            return "";
                                        }
                                    }
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: value => {
                                        return `${value}ms`
                                    }
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