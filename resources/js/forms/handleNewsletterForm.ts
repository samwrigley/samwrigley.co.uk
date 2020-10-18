import handleForm from './handleForm';

const NEWSLETTER_SUBSCRIBE_ROUTE = '/newsletter/subscribe';
const NEWSLETTER_FORM_ID = 'newsletter';

export default function handleNewsletterForm() {
    return handleForm(NEWSLETTER_SUBSCRIBE_ROUTE, NEWSLETTER_FORM_ID);
}
