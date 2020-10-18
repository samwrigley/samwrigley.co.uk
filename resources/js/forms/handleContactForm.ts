import handleForm from './handleForm';

const CONTACT_STORE_ROUTE = '/contact';
const CONTACT_FORM_ID = 'contact';

export default function handleContactForm() {
    return handleForm(CONTACT_STORE_ROUTE, CONTACT_FORM_ID);
}
