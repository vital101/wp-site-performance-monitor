<script>
  import { getStatus } from '../lib/wp-api';
  import { Stretch } from 'svelte-loading-spinners';

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
</script>

<style>
</style>

<div class="dashboard">
  <h1 class="wp-heading-inline">Site Performance Monitor</h1>
  <a href="/" class="page-title-action">
    Refresh Data
  </a>
  <hr class="wp-header-end">
  {#await status}
    <Stretch size="60" color="#1D9AB7" unit="px"></Stretch>
  {:then item}
    <pre>{item.statusComplete ? "Yes" : "No"}</pre>
  {:catch err}
    There was an error {err}
  {/await}
</div>