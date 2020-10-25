import { createClient } from './createClient';
import { TEST_URL, TEST_RESPONSE_DATA } from '../tests';

const client = createClient();

describe('createClient', () => {
    it('returns response data', async () => {
        const { data, response } = await client(TEST_URL, {});

        expect(data).toEqual(TEST_RESPONSE_DATA);
        expect(response.ok).toEqual(true);
        expect(response.url).toEqual(TEST_URL);
    });
});
