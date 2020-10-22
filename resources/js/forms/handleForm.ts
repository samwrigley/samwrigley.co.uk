import createClient, { Body } from '../utilities/createClient';

interface ResponseData {
    message?: string;
}

function getFormFields(form: HTMLFormElement) {
    const inputs = Array.from(form.getElementsByTagName('input'));
    const textareas = Array.from(form.getElementsByTagName('textarea'));

    return [...inputs, ...textareas];
}

function createRequestBodyFromFormFields(fields: (HTMLInputElement | HTMLTextAreaElement)[]) {
    const body: Body = {};

    fields.forEach((input) => {
        body[input.name] = input.value;
    });

    return body;
}

function displayMessage(wrapperElement: HTMLElement, message: string, isError: boolean) {
    if (isError) wrapperElement.classList.add('text-red-700');
    wrapperElement.innerText = message;
    wrapperElement.classList.remove('hidden');
}

export default function handleNewsletterForm(
    url: string,
    formId: string,
    feedbackWrapperId: string = 'feedback'
) {
    const form = document.getElementById(formId) as HTMLFormElement | null;

    if (form) {
        const client = createClient();
        const formFields = getFormFields(form);
        const feedbackWrapper = document.getElementById(feedbackWrapperId);

        form.addEventListener('submit', async (event: Event) => {
            event.preventDefault();

            const body = createRequestBodyFromFormFields(formFields);
            const { data, response } = await client<ResponseData>(url, body);

            if (feedbackWrapper && data.message) {
                displayMessage(feedbackWrapper, data.message, !response.ok);
            }
        });
    }
}
