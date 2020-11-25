import axios from "axios";

const kernlBaseUrl = "https://kernl.us/api/v2/public/site-health";

//
// This function registers the site with Kernl and starts the process for
// getting the initial round of data.
//
// NOTE: This endpoint DOES NOT EXIST yet.
//
export async function bootstrap(siteUrl, uuid, resolution) {
    // const response = await axios.post(`${kernlBaseUrl}/bootstrap`, { spmHash }, {
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'X-WP-Nonce': getNonce()
    //     }
    // });
    // setNonce(response.data.nonce);
    // return response.data.result;
}