import { createClient } from './createClient';
import {
    TEST_URL,
    TEST_REQUEST_DATA,
    TEST_SUCCESS_RESPONSE_DATA,
    getCsrfMetaTagHtml,
} from '../tests';

describe('createClient', () => {
    it('returns response data', async () => {
        document.head.innerHTML = getCsrfMetaTagHtml();

        const client = createClient();
        const { data, response } = await client(TEST_URL, TEST_REQUEST_DATA);

        expect(data).toEqual(TEST_SUCCESS_RESPONSE_DATA);
        expect(response.ok).toEqual(true);
        expect(response.url).toEqual(TEST_URL);
    });
});
