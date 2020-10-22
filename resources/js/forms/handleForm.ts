import { createClient } from '../utilities';
import { createRequestBody } from './createRequestBody';
import { displayFeedback } from './displayFeedback';
import { getFormFieldElements } from './getFormFieldElements';

interface ResponseData {
    message?: string;
}

const client = createClient();

export function handleForm(formId: string, feedbackWrapperId: string = 'feedback') {
    const formElement = document.getElementById(formId) as HTMLFormElement | null;

    if (formElement && formElement.action) {
        const formFieldsElements = getFormFieldElements(formElement);
        const feedbackWrapperElement = document.getElementById(feedbackWrapperId);

        formElement.addEventListener('submit', async (event: Event) => {
            event.preventDefault();

            const requestBody = createRequestBody(formFieldsElements);
            const { data, response } = await client<ResponseData>(formElement.action, requestBody);

            if (feedbackWrapperElement && data.message) {
                displayFeedback(feedbackWrapperElement, data.message, { isError: !response.ok });
            }
        });
    }
}
