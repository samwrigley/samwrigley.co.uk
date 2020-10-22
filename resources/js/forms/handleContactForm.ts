import { handleForm } from './utilities';

const CONTACT_STORE_ROUTE = '/contact';
const CONTACT_FORM_ID = 'contact';

export function handleContactForm() {
    return handleForm(CONTACT_STORE_ROUTE, CONTACT_FORM_ID);
}
