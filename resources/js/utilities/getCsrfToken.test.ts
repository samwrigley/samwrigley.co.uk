import { getCsrfToken } from './getCsrfToken';

const CSRF_TOKEN = '123';

describe('getCsrfToken', () => {
    it('returns token when CSRF token meta tag present', () => {
        document.head.innerHTML = `<meta name="csrf-token" content="${CSRF_TOKEN}">`;

        expect(getCsrfToken()).toEqual(CSRF_TOKEN);
    });

    it('returns undefined when CSRF token meta tag not present', () => {
        document.head.innerHTML = `<meta name="foo" content="bar">`;

        expect(getCsrfToken()).toEqual(undefined);
    });
});
