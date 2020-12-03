import axios from "axios";
import * as wpAPI from "./wp-api";

const kernlBaseUrl = "https://kernl.us/api/v2/public/site-health";

export async function createSite(url, monitoringResolution) {
    const response = await axios.post(kernlBaseUrl, {
        url,
        name: url,
        monitoringResolution
    });
    const id = response.data._id;
    await wpAPI.storeSiteId(id)
    await wpAPI.setStatus(true);
    return id;
}

export async function getSiteData(siteId) {
    const response = await axios.get(`${kernlBaseUrl}/${siteId}`);
    return response.data;
}