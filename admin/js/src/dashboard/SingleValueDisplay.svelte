<script>
    import { parseISO } from 'date-fns';

    export let lastCheck;
    export let monitoringResolution;
    export let value;

    function getNextCheckInMinutes() {
        const lastCheckSeconds = parseISO(lastCheck).getTime() / 1000;
        const nowSeconds = (new Date()).getTime() / 1000;
        const minutesSinceLastCheck = Math.ceil((nowSeconds - lastCheckSeconds) / 60);
        return monitoringResolution - minutesSinceLastCheck;
    }

    const nextCheck = getNextCheckInMinutes();
</script>

<style>
    h1 {
        text-align: center;
        font-size: 80px;
    }

    .smaller {
        font-size: 60px;
    }
</style>

<div class="single-value-display">
    <h1>{value}<span class="smaller">ms</span></h1>
    <p>
        You recently registered your site with Kernl so we only have one value to display.
        {#if nextCheck === 0}
        In <b>less than a minute</b>
        {:else if nextCheck === 1}
        In <b>{nextCheck} minute</b>
        {:else}
        In <b>{nextCheck} minutes</b>
        {/if}
        we will run another performance check against your site and this value will turn into a chart.
    </p>
</div>