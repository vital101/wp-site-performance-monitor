<script>
    import Chart from 'chart.js';
    import { v4 as generateUUID } from 'uuid';
    import { format, parseISO } from 'date-fns';
    import { onMount } from 'svelte';

    export let chartTitle;
    export let data;

    let uuid = generateUUID();
    let myChart;

    const colors = {
        blue: 'rgba(54, 162, 235, 0.2)',
        red: 'rgba(255, 99, 132, 0.2)',
        yellow: 'rgba(255, 206, 86, 0.2)',
        green: 'rgba(75, 192, 192, 0.2)',
        grey: 'rgba(142, 143, 144, 0.2)'
    };

    function setCanvasWidth() {
        if (document) {
            const canvas = document.getElementById(uuid);
            if (canvas && canvas.parentElement) {
                const parent = canvas.parentElement;
                canvas.width = parent.offsetWidth - 60;
                if (myChart && myChart.update) {
                    myChart.update();
                }
            }
        }
    }

    onMount(() => {
        setCanvasWidth();
        window.addEventListener('resize', setCanvasWidth, false);
        if (document) {
            const canvas = document.getElementById(uuid);
            if (canvas) {
                myChart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: data.map(d => format(parseISO(d.date), 'MM/DD/YY')),
                        datasets: [{
                            label: 'Performance',
                            borderWidth: 1,
                            backgroundColor: [ colors.blue ],
                            data: data.map(d => {
                                if (d && d.lighthouse && d.lighthouse.data && d.lighthouse.data.performance) {
                                    return d.lighthouse.data.performance;
                                } else {
                                    return null;
                                }
                            })
                        }, {
                            label: 'Accessibility',
                            borderWidth: 1,
                            backgroundColor: [ colors.green ],
                            data: data.map(d => {
                                if (d && d.lighthouse && d.lighthouse.data && d.lighthouse.data.accessibility) {
                                    return d.lighthouse.data.accessibility;
                                } else {
                                    return null;
                                }
                            })
                        }, {
                            label: 'Best Practices',
                            borderWidth: 1,
                            backgroundColor: [ colors.red ],
                            data: data.map(d => {
                                if (d && d.lighthouse && d.lighthouse.data && d.lighthouse.data.best_practices) {
                                    return d.lighthouse.data.best_practices;
                                } else {
                                    return null;
                                }
                            })
                        }, {
                            label: 'SEO',
                            borderWidth: 1,
                            backgroundColor: [ colors.yellow ],
                            data: data.map(d => {
                                if (d && d.lighthouse && d.lighthouse.data && d.lighthouse.data.seo) {
                                    return d.lighthouse.data.seo;
                                } else {
                                    return null;
                                }
                            })
                        }, {
                            label: 'Progressive Web App',
                            borderWidth: 1,
                            backgroundColor: [ colors.grey ],
                            data: data.map(d => {
                                if (d && d.lighthouse && d.lighthouse.data && d.lighthouse.data.pwa) {
                                    return d.lighthouse.data.pwa;
                                } else {
                                    return null;
                                }
                            })
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Lighthouse Scores'
                                }
                            }]
                        }
                    }
                });
            }
        }
    });
</script>

<style>
p {
    margin-top: 10px;
}
</style>

<div class="panel panel-bordered panel-dark">
    <div class="panel-heading">
        <h3 class="panel-title">{chartTitle}</h3>
    </div>
    <div class="panel-body">
        <canvas id="{uuid}" height="300"></canvas>
        <p>LightHouse is a collection of best practices from Google that help you gauge the performance of your web page. Read more about what these scores mean <a href='https://web.dev/learn/#lighthouse'>here</a>.</p>
    </div>
</div>