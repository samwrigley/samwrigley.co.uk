import { getCsrfToken } from './getCsrfToken';

const CONTENT_TYPE_HEADER_KEY = 'Content-Type';
const CONTENT_TYPE_JSON_HEADER_VALUE = 'application/json';
const CSRF_TOKEN_HEADER_KEY = 'X-CSRF-TOKEN';

export interface RequestBody {
    [key: string]: any;
}

interface Headers {
    [key: string]: string;
}

export function createClient() {
    const csrfToken = getCsrfToken();
    const headers: Headers = { [CONTENT_TYPE_HEADER_KEY]: CONTENT_TYPE_JSON_HEADER_VALUE };

    if (csrfToken) headers[CSRF_TOKEN_HEADER_KEY] = csrfToken;

    return async <T>(url: string, body: RequestBody, method: string = 'POST') => {
        const response = await fetch(url, { method, headers, body: JSON.stringify(body) });
        const data: T = await response.json();

        return { data, response };
    };
}
