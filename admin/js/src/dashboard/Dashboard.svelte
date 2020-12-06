<script>
  import { getSiteId, getStatus } from '../lib/wp-api';
  import CreateSiteForm from './CreateSiteForm.svelte';
  import Loading from '../components/Loading.svelte';
  import ErrorAlert from '../components/ErrorAlert.svelte';
  import TodayDataDashboard from './TodayDataDashboard.svelte';
  import { Container } from 'sveltestrap';
  import { setupComplete, siteId } from './stores';

  // Fetch the site status and id.
  const status = getStatus()
    .then(async data => {
      setupComplete.set(data.setupComplete);
      return getSiteId();
    }).then(activeSiteId => {
      siteId.set(activeSiteId);
    });
 const errorMessage = "There was an error fetching the performance monitor status.";
</script>

<style>

</style>

<div class="dashboard">
  <h1 class="wp-heading-inline">Site Performance Monitor</h1>
  <hr class="wp-header-end">
  <Container>
    {#await status}
      <Loading></Loading>
    {:then}
      {#if $setupComplete && $siteId}
        <TodayDataDashboard></TodayDataDashboard>
      {:else}
        <CreateSiteForm></CreateSiteForm>
      {/if}
    {:catch}
      <ErrorAlert message={errorMessage}></ErrorAlert>
    {/await}
  </Container>
</div>