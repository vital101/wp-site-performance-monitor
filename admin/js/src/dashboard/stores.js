import { writable } from 'svelte/store';

export const setupComplete = writable(false);
export const siteId = writable(null);