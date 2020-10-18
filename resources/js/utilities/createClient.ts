import getCsrfToken from './getCsrfToken';

export interface Body {
    [key: string]: any;
}

interface Headers {
    [key: string]: string;
}

export default function createClient() {
    const csrfToken = getCsrfToken();
    const headers: Headers = { 'Content-Type': 'application/json' };

    if (csrfToken) headers['X-CSRF-TOKEN'] = csrfToken;

    return async (url: string, body: Body, method: string = 'POST') => {
        const response = await fetch(url, { method, headers, body: JSON.stringify(body) });

        return await response.json();
    };
}
