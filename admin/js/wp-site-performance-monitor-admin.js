($ => {

	// Bootstrap the admin page is active.
	const adminContainer = document.getElementById("site-performance-monitor-admin-container");
	if (adminContainer) {
		const app = Vue.createApp({});
		app.component('MyComponent', MyComponentFunction); // Imported from enqueue scripts
		app.mount('#myId');
	}

	// Bootstrap the dashboard widget.
	// WIP
})(jQuery);
