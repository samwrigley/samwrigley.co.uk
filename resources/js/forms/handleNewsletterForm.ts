import createClient from '../utilities/createClient';

const CLIENT = createClient();

const NEWSLETTER_FORM_ID = 'newsletter';
const EMAIL_INPUT_ID = 'email';
const ERROR_MESSAGE_ID = 'errors';

const NEWSLETTER_SUBSCRIBE_ROUTE = '/newsletter/subscribe';

export default function handleNewsletterForm() {
    const newsletterFormElement = document.getElementById(NEWSLETTER_FORM_ID);
    const emailInputElement = document.getElementById(EMAIL_INPUT_ID) as HTMLInputElement | null;
    const errorMessageElement = document.getElementById(ERROR_MESSAGE_ID);

    if (newsletterFormElement) {
        newsletterFormElement.addEventListener('submit', async (event: Event) => {
            event.preventDefault();

            const response = await CLIENT(NEWSLETTER_SUBSCRIBE_ROUTE, {
                email: emailInputElement?.value,
            });

            if (errorMessageElement) errorMessageElement.innerText = response.message;
        });
    }
}
