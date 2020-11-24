import Settings from "./settings/Settings.svelte";
import Dashboard from "./dashboard/Dashboard.svelte";

var app;
var topLevelEl = document.getElementById("kernl-spm-top-level");
if (topLevelEl) {
  app = new Dashboard({ target: topLevelEl });
}

var settingsEl = document.getElementById("kernl-spm-settings-container");
if (settingsEl) {
  app = new Settings({ target: settingsEl });
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
