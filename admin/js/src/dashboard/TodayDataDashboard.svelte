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
    import { siteId } from './stores';
    import { getSiteData } from '../lib/kernl-site-health';

    const loadingSize = 40;
    const loading = getSiteData($siteId)
        .then(siteData => {
            console.log({ siteData });
        });
</script>

<style>

</style>

<Row>
    <Col sm=6>
        <Card>
            <CardHeader>
                <CardTitle>Response Time</CardTitle>
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
        <Card>
            <CardHeader>
                <CardTitle>Time to First Byte (TTFB)</CardTitle>
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
</Row>
<Row>
    <Col sm=6>
        <Card>
            <CardHeader>
                <CardTitle>Google Lighthouse Scores</CardTitle>
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