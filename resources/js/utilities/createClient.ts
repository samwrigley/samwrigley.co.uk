import { getCsrfToken } from './getCsrfToken';

export const CONTENT_TYPE_HEADER_KEY = 'Content-Type';
export const ACCEPT_HEADER_KEY = 'Accept';
export const CSRF_TOKEN_HEADER_KEY = 'X-CSRF-TOKEN';
export const APPLICATION_JSON_MIME_TYPE = 'application/json';

export interface RequestBody {
    [key: string]: any;
}

interface Headers {
    [key: string]: string;
}

export function createClient() {
    const csrfToken = getCsrfToken();
    const headers: Headers = {
        [CONTENT_TYPE_HEADER_KEY]: APPLICATION_JSON_MIME_TYPE,
        [ACCEPT_HEADER_KEY]: APPLICATION_JSON_MIME_TYPE,
    };

    if (csrfToken) headers[CSRF_TOKEN_HEADER_KEY] = csrfToken;

    return async <T>(url: string, body: RequestBody, method: string = 'POST') => {
        const response = await fetch(url, { method, headers, body: JSON.stringify(body) });
        const data: T = await response.json();

        return { data, response };
    };
}
