import { getCsrfMetaTagHtml, CSRF_TOKEN } from '../tests';
import { getCsrfToken } from './getCsrfToken';

describe('getCsrfToken', () => {
    beforeEach(() => {
        document.head.innerHTML = '';
    });

    it('returns token when CSRF token meta tag present', () => {
        document.head.innerHTML = getCsrfMetaTagHtml();

        expect(getCsrfToken()).toEqual(CSRF_TOKEN);
    });

    it('returns undefined when CSRF token meta tag not present', () => {
        document.head.innerHTML = `<meta name="foo" content="bar">`;

        expect(getCsrfToken()).toEqual(undefined);
    });
});
