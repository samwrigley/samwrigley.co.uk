import { MockedRequest, rest } from 'msw';
import {
    CONTENT_TYPE_HEADER_KEY,
    CONTENT_TYPE_JSON_HEADER_VALUE,
    CSRF_TOKEN_HEADER_KEY,
    TEST_FAILURE_RESPONSE_MESSAGE_TEXT,
    TEST_INPUT_NAME,
    TEST_INPUT_VALUE,
    TEST_SUCCESS_RESPONSE_DATA,
    TEST_URL,
} from './consts';

interface Request {
    [key: string]: string;
}

const handlers = [
    rest.post<Request>(TEST_URL, (req, res, ctx) => {
        if (!hasContentTypeJsonHeader(req) || !hasCsrfTokenHeader(req) || !hasRequestBody(req)) {
            return res(ctx.status(400), ctx.json(TEST_FAILURE_RESPONSE_MESSAGE_TEXT));
        }

        return res(ctx.json(TEST_SUCCESS_RESPONSE_DATA));
    }),
];

function hasContentTypeJsonHeader(req: MockedRequest<Request>) {
    return req.headers.get(CONTENT_TYPE_HEADER_KEY) === CONTENT_TYPE_JSON_HEADER_VALUE;
}

function hasCsrfTokenHeader(req: MockedRequest<Request>) {
    return req.headers.has(CSRF_TOKEN_HEADER_KEY);
}

function hasRequestBody(req: MockedRequest<Request>) {
    return req.body[TEST_INPUT_NAME] === TEST_INPUT_VALUE;
}

export { handlers };
