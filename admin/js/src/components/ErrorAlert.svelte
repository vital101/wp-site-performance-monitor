<script>
    import { Alert, Col, Row } from 'sveltestrap';
    export let message = 'There was an error';
</script>

<style>
    .center-text {
        text-align: center;
        padding-top: 50px;
    }
</style>

<Row>
    <Col xs="2"></Col>
    <Col xs="8">
        <div class="center-text">
            <Alert color="danger">
                { message }
            </Alert>
        </div>
    </Col>
    <Col xs="2"></Col>
</Row>