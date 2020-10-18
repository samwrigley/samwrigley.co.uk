import createClient, { Body } from '../utilities/createClient';

const CLIENT = createClient();

function getFormFields(form: HTMLFormElement | null) {
    const inputs = Array.from(form?.getElementsByTagName('input') || []);
    const textareas = Array.from(form?.getElementsByTagName('textarea') || []);

    return [...inputs, ...textareas];
}

function createRequestBodyFromFormFields(fields: (HTMLInputElement | HTMLTextAreaElement)[]) {
    const body: Body = {};

    fields.forEach((input) => {
        body[input.name] = input.value;
    });

    return body;
}

export default function handleNewsletterForm(
    url: string,
    formId: string,
    errorId: string = 'error'
) {
    const form = document.getElementById(formId) as HTMLFormElement | null;

    if (form) {
        form.addEventListener('submit', async (event: Event) => {
            event.preventDefault();

            const formFields = getFormFields(form);
            const body = createRequestBodyFromFormFields(formFields);
            const errorMessage = document.getElementById(errorId);

            const response = await CLIENT(url, body);

            if (errorMessage) errorMessage.innerText = response.message;
        });
    }
}
