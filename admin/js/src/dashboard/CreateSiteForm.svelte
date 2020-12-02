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
    import Loading from './Loading.svelte';
    import { setupComplete, siteId } from './stores';
    import { forceWait } from '../lib/wp-api';
    import { createSite } from '../lib/kernl-site-health';

    const kernlLogo = window.kernlLogoUrl;
    const siteUrl = window.siteUrl;
    const model = {
        siteUrl,
        uuid: uuidv4(),
        resolution: 10,
    };
    let saving = false;
    $: canSave = model.siteUrl && model.siteUrl.trim() !== '';

    async function save() {
        saving = true;
        const newSiteId = await createSite(model.siteUrl, model.resolution);
        await forceWait(2);
        siteId.set(newSiteId)
        setupComplete.set(true); // Set this once everything is done.
    }
</script>

<style>
    .logo-container {
        text-align: center;
    }

    .logo-container img {
        width: 200px;
        margin-bottom: 20px;
    }

    .waiting-message {
        text-align: center;
    }
</style>

<Row>
    <Col xs="3"></Col>
    <Col xs="6">
        <Card>
            <CardBody>
                <div class="logo-container">
                    <a target="_blank" href="https://kernl.us">
                        <img src={kernlLogo} alt="Kernl logo">
                    </a>
                </div>
                {#if !saving}
                    <p>
                        Thanks for activating Kernl WordPress Site Performance monitor! The next step is to register your site so Kernl can start monitoring it for you.
                    </p>
                    <Form>
                        <FormGroup>
                            <Label for="siteUrl">Site URL</Label>
                            <Input
                                name="siteUrl"
                                type="text"
                                bind:value={model.siteUrl} />
                            <FormText color="muted">
                                The URL that Kernl will check for things like response time, TTFB (Time to first byte), and Google Lighthouse scores.
                            </FormText>
                        </FormGroup>
                    </Form>
                {:else}
                    <Loading></Loading>
                    <div class="waiting-message">
                        <p>We're now registering your site with Kernl.</p>
                    </div>
                {/if}
            </CardBody>
            {#if !saving}
                <CardFooter>
                    <Button
                        color="primary"
                        on:click={save}
                        disabled={!canSave || saving}>Looks good. Start monitoring!</Button>
                </CardFooter>
            {/if}
        </Card>
    </Col>
    <Col xs="3"></Col>
</Row>