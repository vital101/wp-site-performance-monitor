import axios from "axios";

const BASE_URL = '/wp-json/kernl/v1';

export async function getStatus() {
    await forceWait();
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

function forceWait() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve();
            // reject();
        }, 1000);
    });
}