import { TEST_CSRF_TOKEN } from './consts';

export function getCsrfMetaTagHtml(csrfToken = TEST_CSRF_TOKEN) {
    return `<meta name="csrf-token" content="${csrfToken}">`;
}
