<script>
    import {
        Row,
        Col,
        Card,
        CardBody,
        CardHeader,
        CardTitle
    } from 'sveltestrap';
    import Loading from './Loading.svelte';
    import LineChart from './LineChart.svelte';
    import { siteId } from './stores';
    import { getSiteData } from '../lib/kernl-site-health';

    let responseTimeChartProps = null;
    let ttfbChartProps = null;
    const loadingSize = 40;
    const loading = getSiteData($siteId)
        .then(siteData => {
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
        });
</script>

<style>

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
                <CardTitle>Google Lighthouse Scores - THE DATE GOES HERE</CardTitle>
            </CardHeader>
            <CardBody>
                {#await loading}
                    <Loading size={loadingSize}></Loading>
                {:then done}
                    WIP
                {/await}
            </CardBody>
        </Card>
    </Col>
    <Col sm=6>
    </Col>
</Row>