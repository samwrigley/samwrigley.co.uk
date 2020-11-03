import { MockedRequest, rest } from 'msw';
import {
    CONTENT_TYPE_HEADER_KEY,
    CONTENT_TYPE_JSON_HEADER_VALUE,
    CSRF_TOKEN_HEADER_KEY,
    FAILURE_RESPONSE_DATA,
    INPUT_NAME,
    INPUT_VALUE,
    SUCCESS_RESPONSE_DATA,
    URL,
} from './consts';

interface Request {
    [key: string]: string;
}

const handlers = [
    rest.post<Request>(URL, (req, res, ctx) => {
        if (!hasContentTypeJsonHeader(req) || !hasCsrfTokenHeader(req) || !hasRequestBody(req)) {
            return res(ctx.status(400), ctx.json(FAILURE_RESPONSE_DATA));
        }

        return res(ctx.json(SUCCESS_RESPONSE_DATA));
    }),
];

function hasContentTypeJsonHeader(req: MockedRequest<Request>) {
    return req.headers.get(CONTENT_TYPE_HEADER_KEY) === CONTENT_TYPE_JSON_HEADER_VALUE;
}

function hasCsrfTokenHeader(req: MockedRequest<Request>) {
    return req.headers.has(CSRF_TOKEN_HEADER_KEY);
}

function hasRequestBody(req: MockedRequest<Request>) {
    return req.body[INPUT_NAME] === INPUT_VALUE;
}

export { handlers };
