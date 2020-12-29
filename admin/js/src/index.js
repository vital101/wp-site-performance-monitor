import Dashboard from "./dashboard/Dashboard.svelte";

let app;
let topLevelEl = document.getElementById("kernl-spm-top-level");
if (topLevelEl) {
  app = new Dashboard({ target: topLevelEl });
}

export default app;

// Hot Module Replacement (HMR) - Remove this snippet to remove HMR.
// Learn more: https://www.snowpack.dev/#hot-module-replacement
if (import.meta.hot) {
  import.meta.hot.accept();
  import.meta.hot.dispose(() => {
    app.$destroy();
  });
}
