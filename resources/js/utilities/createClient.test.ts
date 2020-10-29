import { createClient } from './createClient';
import { URL, REQUEST_DATA, SUCCESS_RESPONSE_DATA, getCsrfMetaTagHtml } from '../tests';

describe('createClient', () => {
    it('returns response data', async () => {
        document.head.innerHTML = getCsrfMetaTagHtml();

        const client = createClient();
        const { data, response } = await client(URL, REQUEST_DATA);

        expect(data).toEqual(SUCCESS_RESPONSE_DATA);
        expect(response.ok).toEqual(true);
        expect(response.url).toEqual(URL);
    });
});
