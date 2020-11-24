<script>
  import {onMount} from 'svelte';
  const spmHash = window.kernlSpmHash;
  let count = 0;
  onMount(() => {
    const interval = setInterval(() => count++, 1000);
    return () => {
      clearInterval(interval);
    };
  });
</script>

<style>
  .Settings {
    border: 1px solid red;
  }
</style>

<div class="Settings">
  <h1>This is settings {count}</h1>
  <p>{spmHash}</p>
</div>
