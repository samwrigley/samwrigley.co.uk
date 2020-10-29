import { getCsrfMetaTagHtml } from '../tests';
import { getCsrfToken } from './getCsrfToken';

const CSRF_TOKEN = '123';

describe('getCsrfToken', () => {
    it('returns token when CSRF token meta tag present', () => {
        document.head.innerHTML = getCsrfMetaTagHtml();

        expect(getCsrfToken()).toEqual(CSRF_TOKEN);
    });

    it('returns undefined when CSRF token meta tag not present', () => {
        document.head.innerHTML = `<meta name="foo" content="bar">`;

        expect(getCsrfToken()).toEqual(undefined);
    });
});
