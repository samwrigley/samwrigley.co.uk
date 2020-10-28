import { rest } from 'msw';

export const TEST_URL = 'https://example.com/contact';
export const TEST_RESPONSE_MESSAGE_TEXT = 'Message';
export const TEST_RESPONSE_DATA = { message: TEST_RESPONSE_MESSAGE_TEXT };

const handlers = [
    rest.post(TEST_URL, (_req, res, ctx) => {
        return res(ctx.json(TEST_RESPONSE_DATA));
    }),
];

export { handlers };
