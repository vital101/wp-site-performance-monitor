<script>
    import {
        Button,
        Card,
        CardBody,
        CardFooter,
        Col,
        Form,
        FormGroup,
        FormText,
        Input,
        Label,
        Row
    } from 'sveltestrap';
    import { v4 as uuidv4 } from 'uuid';
    const siteUrl = window.siteUrl;
    const model = {
        siteUrl,
        uuid: uuidv4(),
        resolution: 10,
    };
    $: canSave = model.siteUrl && model.siteUrl.trim() !== '';
</script>

<style>
</style>

<Row>
    <Col xs="3"></Col>
    <Col xs="6">
        <Card>
            <CardBody>
                <p>
                    Thanks for activating the Kernl WordPress Site Performance monitor plugin! The next step is to register your site so Kernl can start monitoring it for you.
                </p>
                <Form>
                    <FormGroup>
                        <Label for="siteUrl">Site URL</Label>
                        <Input
                            name="siteUrl"
                            type="text"
                            bind:value={model.siteUrl} />
                        <FormText color="muted">
                            The URL that Kernl will check for things like response time and TTFB (Time to first byte).
                        </FormText>
                    </FormGroup>
                    <FormGroup>
                        <Label for="uuid">Identifier</Label>
                        <Input
                            disabled
                            name="uuid"
                            type="text"
                            bind:value={model.uuid} />
                        <FormText color="muted">
                            The identifier that Kernl uses to index your data. No action necessary.
                        </FormText>
                    </FormGroup>
                </Form>
            </CardBody>
            <CardFooter>
                <Button
                    color="primary"
                    disabled={!canSave}>Looks good. Start monitoring!</Button>
            </CardFooter>
        </Card>
    </Col>
    <Col xs="3"></Col>
</Row>