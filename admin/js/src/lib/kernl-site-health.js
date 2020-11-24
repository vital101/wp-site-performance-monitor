import axios from "axios";

const kernlBaseUrl = "https://kernl.us/api/v2/public/site-health";

// WIP -> This should actually send a bunch of data (url, frequence, etc)
export async function bootstrap(spmHash) {
    // const response = await axios.post(`${kernlBaseUrl}/bootstrap`, { spmHash }, {
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'X-WP-Nonce': getNonce()
    //     }
    // });
    // setNonce(response.data.nonce);
    // return response.data.result;
}