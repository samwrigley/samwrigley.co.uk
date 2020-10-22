import { RequestBody } from '../utilities';

export function createRequestBody(fields: (HTMLInputElement | HTMLTextAreaElement)[]) {
    const body: RequestBody = {};

    fields.forEach((input) => {
        body[input.name] = input.value;
    });

    return body;
}
