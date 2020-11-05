import { createClient } from '../utilities';
import { createRequestBody } from './createRequestBody';
import { displayFeedback } from './displayFeedback';
import { getFormFieldElements } from './getFormFieldElements';

interface ResponseData {
    message?: string;
    errors?: {
        messages: string[];
    };
}

export function handleForm(formElement: HTMLFormElement, feedbackWrapperId: string = 'feedback') {
    if (!formElement.action || formElement.method.toLowerCase() !== 'post') return;

    const client = createClient();
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
