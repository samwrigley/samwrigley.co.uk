import { createClient } from '../../utilities';
import { createRequestBody } from './createRequestBody';
import { displayFeedback } from './displayFeedback';
import { getFormFieldElements } from './getFormFieldElements';

interface ResponseData {
    message?: string;
}

export function handleForm(url: string, formId: string, feedbackWrapperId: string = 'feedback') {
    const form = document.getElementById(formId) as HTMLFormElement | null;

    if (form) {
        const client = createClient();
        const formFields = getFormFieldElements(form);
        const feedbackWrapper = document.getElementById(feedbackWrapperId);

        form.addEventListener('submit', async (event: Event) => {
            event.preventDefault();

            const body = createRequestBody(formFields);
            const { data, response } = await client<ResponseData>(url, body);

            if (feedbackWrapper && data.message) {
                displayFeedback(feedbackWrapper, data.message, { isError: !response.ok });
            }
        });
    }
}
