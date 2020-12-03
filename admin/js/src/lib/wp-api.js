import axios from "axios";

const BASE_URL = '/wp-json/kernl/v1';

export async function getStatus() {
    const response = await axios({
        method: 'GET',
        url: `${BASE_URL}/status`,
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': wpApiSettings.nonce,
        }
    });
    return response.data;
}

export async function getSiteId() {
    const response = await axios({
        method: 'GET',
        url: `${BASE_URL}/site`,
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': wpApiSettings.nonce,
        }
    });
    return response.data.siteId;
}

export async function storeSiteId(siteId) {
    await axios({
        method: 'POST',
        url: `${BASE_URL}/site`,
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': wpApiSettings.nonce,
        },
        data: { siteId }
    });
}

export async function setStatus(status) {
    await axios({
        method: 'POST',
        url: `${BASE_URL}/status`,
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': wpApiSettings.nonce,
        },
        data: { status }
    });
}

export function forceWait(timeInSeconds) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve();
        }, timeInSeconds * 1000);
    });
}