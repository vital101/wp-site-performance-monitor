<script>
  import { getStatus } from '../lib/wp-api';
  import CreateSiteForm from './CreateSiteForm.svelte';
  import Loading from './Loading.svelte';
  import ErrorAlert from './ErrorAlert.svelte';
  import { Container } from 'sveltestrap';

  /*
  1. If no "kernl-spm-setup-complete" option  (get via REST endpoint)
    1a. Display form for site setup.
      - SiteURL (for verification)
      - Site Identifier (uuid)
      - How often should we monitor? (resolution) [10, 5, 1]
    1b. Submit to Kernl.
  2. Set setup-complete option via REST endpoint.
  3. Start loading spinner. Long-poll Kernl for data every 3 seconds.
  4. Once data retrieved, render charts etc.
  5. Only update data on page load. If use wants to do it manually, click
     the "Refresh Data" button at top of page.
  6. When we get more data (multiple days) start putting in WordPress database
     so we can fetch quickly and keep load off of Kernl if at all possible.
  7. Eventually: Notification thresholds
  */
 const status = getStatus();
 let setupComplete = false;
 status.then(data => {
   setupComplete = data.setupComplete;
   if (setupComplete) {
     // Check to see if there is data yet.
     // If yes, display.
     // If no, display message. Ask use if they want to be emailed when ready.
   } else {
     console.log(2);
     // Show form for registering site.
     // Long-poll Kernl to see if ready yet. Once ready, show the things.
   }
 }).catch(err => {
    console.log(err);
 });
 const errorMessage = "There was an error fetching the performance monitor status.";
</script>

<style>

</style>

<div class="dashboard">
  <h1 class="wp-heading-inline">Site Performance Monitor</h1>
  <a href="/" class="page-title-action">
    Refresh Data
  </a>
  <hr class="wp-header-end">
  <Container>
    {#await status}
      <Loading></Loading>
    {:then item}
      {#if setupComplete}
        <p>Setup Done.</p>
      {:else}
        <CreateSiteForm></CreateSiteForm>
      {/if}
    {:catch}
      <ErrorAlert message={errorMessage}></ErrorAlert>
    {/await}
  </Container>
</div>