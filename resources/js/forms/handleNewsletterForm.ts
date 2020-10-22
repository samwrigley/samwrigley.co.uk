import { handleForm } from './utilities';

const NEWSLETTER_SUBSCRIBE_ROUTE = '/newsletter/subscribe';
const NEWSLETTER_FORM_ID = 'newsletter';

export function handleNewsletterForm() {
    return handleForm(NEWSLETTER_SUBSCRIBE_ROUTE, NEWSLETTER_FORM_ID);
}
