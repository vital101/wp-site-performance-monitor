<script>
    import Chart from 'chart.js';
    import { v4 as generateUUID } from 'uuid';
    import { afterUpdate, onMount } from 'svelte';

    export let data;

    let uuid = generateUUID();

    const colors = {
        blue: 'rgba(54, 162, 235, 0.2)',
        red: 'rgba(255, 99, 132, 0.2)',
        yellow: 'rgba(255, 255, 102, 0.2)',
        green: 'rgba(75, 192, 192, 0.2)',
        orange: 'rgba(255, 187, 51, 0.2)',
        blue_bold: 'rgba(54, 162, 235, 0.8)',
        red_bold: 'rgba(255, 99, 132, 0.8)',
        yellow_bold: 'rgba(204, 204, 0, 0.8)',
        green_bold: 'rgba(75, 192, 192, 0.8)',
        orange_bold: 'rgba(255, 187, 51, 0.8)'
    };

    function updateChart() {
        if (document) {
            const canvas = document.getElementById(uuid);
            if (canvas) {
                new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: [
                            'Performance',
                            'Accessibility',
                            'Best Practices',
                            'SEO',
                            'Progressive Web App'
                        ],
                        legend: { display: false },
                        datasets: [{
                            data: [
                                data.performance,
                                data.accessibility,
                                data.best_practices,
                                data.seo,
                                data.pwa
                            ],
                            backgroundColor: [
                                colors.red,
                                colors.orange,
                                colors.yellow,
                                colors.green,
                                colors.blue
                            ],
                            borderColor: [
                                colors.red_bold,
                                colors.orange_bold,
                                colors.yellow_bold,
                                colors.green_bold,
                                colors.blue_bold
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    suggestedMin: 0,
                                    suggestedMax: 100
                                }
                            }]
                        }
                    }
                });
            }
        }
    }

    afterUpdate(() => {
        if (showCanvas()) {
            updateChart();
        }
    });

    onMount(() => {
        if (showCanvas()) {
            updateChart();
        }
    });

    function showCanvas() {
        return data.accessibility !== null && data.accessibility !== undefined;
    }
</script>

<style></style>

{#if showCanvas()}
    <canvas id="{uuid}" height="300"></canvas>
{:else}
    There is currently no data available. It can take up to 5 minutes to initially populate this data.
{/if}