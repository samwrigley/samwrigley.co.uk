import { RequestBody } from '../utilities';

export function createRequestBody(fieldElements: (HTMLInputElement | HTMLTextAreaElement)[]) {
    const body: RequestBody = {};

    fieldElements.forEach((fieldElement) => {
        body[fieldElement.name] = fieldElement.value;
    });

    return body;
}
