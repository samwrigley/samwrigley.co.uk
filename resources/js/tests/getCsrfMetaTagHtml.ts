import { CSRF_TOKEN } from './consts';

export function getCsrfMetaTagHtml(csrfToken = CSRF_TOKEN) {
    return `<meta name="csrf-token" content="${csrfToken}">`;
}
