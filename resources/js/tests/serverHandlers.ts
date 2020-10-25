import { rest } from 'msw';

export const TEST_URL = 'https://example.com/contact';
export const TEST_RESPONSE_DATA = { message: 'Message' };

const handlers = [
    rest.post(TEST_URL, (_req, res, ctx) => {
        return res(ctx.json(TEST_RESPONSE_DATA));
    }),
];

export { handlers };
