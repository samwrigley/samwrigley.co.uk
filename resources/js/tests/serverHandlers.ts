import { rest } from 'msw';

export const TEST_URL = 'https://example.com/test';

export const TEST_INPUT_NAME = 'test-name';
export const TEST_INPUT_VALUE = 'test-value';
export const TEST_REQUEST_DATA = { [TEST_INPUT_NAME]: TEST_INPUT_VALUE };

export const TEST_SUCCESS_RESPONSE_MESSAGE_TEXT = 'Success';
export const TEST_SUCCESS_RESPONSE_DATA = { message: TEST_SUCCESS_RESPONSE_MESSAGE_TEXT };
export const TEST_FAILURE_RESPONSE_MESSAGE_TEXT = 'Failure';
export const TEST_FAILURE_RESPONSE_DATA = { message: TEST_SUCCESS_RESPONSE_MESSAGE_TEXT };

interface Request {
    [key: string]: string;
}

const handlers = [
    rest.post<Request>(TEST_URL, (req, res, ctx) => {
        if (req.body[TEST_INPUT_NAME] !== TEST_INPUT_VALUE) {
            return res(ctx.status(400), ctx.json(TEST_FAILURE_RESPONSE_MESSAGE_TEXT));
        }

        return res(ctx.json(TEST_SUCCESS_RESPONSE_DATA));
    }),
];

export { handlers };
