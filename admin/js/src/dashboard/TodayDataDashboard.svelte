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
    import RunningSiteMonitor from './RunningSiteMonitor.svelte';
    import { siteId, site } from './stores';
    import { getSiteData } from '../lib/kernl-site-health';
    import { forceWait } from '../lib/wp-api';
    import { parseISO, format } from 'date-fns';

    const kernlLogo = window.kernlLogoUrl;
    let responseTimeChartProps = null;
    let ttfbChartProps = null;
    let lighthouseProps = null;
    let lighthouseDate = null;
    let hasData = false;
    const loadingSize = 40;

    function siteHasData(siteData) {
        return siteData &&
            siteData.responseTime &&
            siteData.responseTime.length > 0 &&
            siteData.ttfb &&
            siteData.ttfb.length > 0 &&
            siteData.lighthouse &&
            siteData.lighthouse.hasOwnProperty('scores') &&
            siteData.lighthouse.scores.hasOwnProperty('pwa');
    }

    function buildPropsAndFormatData(siteData) {
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
    }

    async function waitForData() {
        let siteData;
        do {
            await forceWait(1);
            siteData = await getSiteData($siteId);
        } while(!siteHasData(siteData));
        buildPropsAndFormatData(siteData);
        hasData = true;
    }

    // Init
    const loading = getSiteData($siteId)
        .then(siteData => {
            hasData = siteHasData(siteData);
            if (hasData) {
                buildPropsAndFormatData(siteData);
            } else {
                waitForData();
            }
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
                {:then}
                    {#if !hasData}
                        <RunningSiteMonitor></RunningSiteMonitor>
                    {:else}
                        <LineChart {...responseTimeChartProps}></LineChart>
                    {/if}
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
                {:then}
                    {#if !hasData}
                        <RunningSiteMonitor></RunningSiteMonitor>
                    {:else}
                        <LineChart {...ttfbChartProps}></LineChart>
                    {/if}
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
                {:then}
                    {#if !hasData}
                        <RunningSiteMonitor></RunningSiteMonitor>
                    {:else}
                        <BarChart {...lighthouseProps}></BarChart>
                    {/if}
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
