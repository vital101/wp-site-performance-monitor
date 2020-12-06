<script>
    import {
        Row,
        Col,
        Card,
        CardBody,
        CardHeader,
        CardTitle
    } from 'sveltestrap';
    import Loading from '../components/Loading.svelte';
    import LineChart from './LineChart.svelte';
    import BarChart from './BarChart.svelte';
    import { siteId, site } from './stores';
    import { getSiteData } from '../lib/kernl-site-health';
    import { parseISO, format } from 'date-fns';

    const kernlLogo = window.kernlLogoUrl;
    let responseTimeChartProps = null;
    let ttfbChartProps = null;
    let lighthouseProps = null;
    let lighthouseDate = null;
    const loadingSize = 40;
    const loading = getSiteData($siteId)
        .then(siteData => {
            site.set(siteData.site);
            responseTimeChartProps = {
                chartTitle: 'Response Time',
                dataAxisLabel: 'Time in milliseconds',
                dataLabel: 'Response Time',
                dataColor: 'red',
                data: siteData.responseTime
            };
            ttfbChartProps = {
                chartTitle: 'TTFB',
                dataAxisLabel: 'Time in milliseconds',
                dataLabel: 'TTFB',
                dataColor: 'blue',
                data: siteData.ttfb
            };
            lighthouseProps = {
                data: siteData.lighthouse.scores
            };
            lighthouseDate = format(parseISO(siteData.lighthouse.lastCheck), 'LLL d y');
        });
</script>

<style>
.logo-container {
    text-align: center;
}

.logo-container img {
    width: 200px;
    margin-bottom: 20px;
}

</style>

<Row>
    <Col sm=6>
        <Card>
            <CardHeader>
                <CardTitle>Response Time - Last 24 Hours</CardTitle>
            </CardHeader>
            <CardBody>
                {#await loading}
                    <Loading size={loadingSize}></Loading>
                {:then done}
                    <LineChart {...responseTimeChartProps}></LineChart>
                {/await}
            </CardBody>
        </Card>
    </Col>
    <Col sm=6>
        <Card>
            <CardHeader>
                <CardTitle>Time to First Byte (TTFB) - Last 24 Hours</CardTitle>
            </CardHeader>
            <CardBody>
                {#await loading}
                    <Loading size={loadingSize}></Loading>
                {:then done}
                    <LineChart {...ttfbChartProps}></LineChart>
                {/await}
            </CardBody>
        </Card>
    </Col>
</Row>
<Row>
    <Col sm=6>
        <Card>
            <CardHeader>
                <CardTitle>Google Lighthouse Scores
                    {#if lighthouseDate}
                        for { lighthouseDate }
                    {/if}
                </CardTitle>
            </CardHeader>
            <CardBody>
                {#await loading}
                    <Loading size={loadingSize}></Loading>
                {:then data}
                    <BarChart {...lighthouseProps}></BarChart>
                {/await}
            </CardBody>
        </Card>
    </Col>
    <Col sm=6>
        {#if $site}
            <Card>
                <CardBody>
                    <div class="logo-container">
                        <ul>
                            <li><b>URL:</b> {$site.url}</li>
                            <li><b>Monitoring Resolution:</b> {$site.monitoringResolution} minutes</li>
                            <li><b>ID:</b> {$site.id}</li>
                        </ul>
                        <a target="_blank" href="https://kernl.us">
                            <img src={kernlLogo} alt="Kernl logo">
                        </a>
                        <p>WordPress Performance Monitor is brought to you by <a href='https://kernl.us'>Kernl</a>.</p>
                    </div>
                </CardBody>
            </Card>
        {/if}
    </Col>
</Row>