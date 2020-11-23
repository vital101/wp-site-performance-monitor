<script>
    import {onMount} from 'svelte';
    let count = 0;
    onMount(() => {
      const interval = setInterval(() => count++, 1000);
      return () => {
        clearInterval(interval);
      };
    });
  </script>

<style>
.dashboard {
    text-align: center;
}
</style>

<div class="dashboard">
    <h1>This is the dashboard {count}</h1>
</div>