import { MockedRequest, rest } from 'msw';
import {
    ACCEPT_HEADER_KEY,
    APPLICATION_JSON_MIME_TYPE,
    CONTENT_TYPE_HEADER_KEY,
    CSRF_TOKEN_HEADER_KEY,
} from '../utilities';
import {
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
        if (!hasHeaders(req) || !hasRequestBody(req)) {
            return res(ctx.status(400), ctx.json(FAILURE_RESPONSE_DATA));
        }

        return res(ctx.json(SUCCESS_RESPONSE_DATA));
    }),
];

function hasHeaders(req: MockedRequest<Request>) {
    return (
        req.headers.get(CONTENT_TYPE_HEADER_KEY) === APPLICATION_JSON_MIME_TYPE &&
        req.headers.get(ACCEPT_HEADER_KEY) === APPLICATION_JSON_MIME_TYPE &&
        req.headers.has(CSRF_TOKEN_HEADER_KEY)
    );
}

function hasRequestBody(req: MockedRequest<Request>) {
    return req.body[INPUT_NAME] === INPUT_VALUE;
}

export { handlers };
