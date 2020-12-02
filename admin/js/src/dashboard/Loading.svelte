<script>
    import { Stretch } from 'svelte-loading-spinners';
    import { Col, Row } from 'sveltestrap';
    export let size = 60;

    const props = {
        size,
        color: "#1D9AB7",
        unit: "px"
    };
</script>

<style>
    .center-text {
        text-align: center;
        padding-top: 50px;
    }
</style>

<Row>
    <Col xs="4"></Col>
    <Col xs="4">
        <div class="center-text">
            <Stretch {...props}></Stretch>
        </div>
    </Col>
    <Col xs="4"></Col>
</Row>