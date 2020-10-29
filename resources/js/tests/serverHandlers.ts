import { rest } from 'msw';
import {
    TEST_URL,
    TEST_INPUT_NAME,
    TEST_INPUT_VALUE,
    TEST_FAILURE_RESPONSE_MESSAGE_TEXT,
    TEST_SUCCESS_RESPONSE_DATA,
} from './consts';

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
