import { TEST_INPUT_NAME, TEST_INPUT_VALUE } from '../tests';
import { createRequestBody } from './createRequestBody';

const INPUT_ELEMENT = createElement('input', TEST_INPUT_NAME, TEST_INPUT_VALUE);

const TEXTAREA_NAME = 'message';
const TEXTAREA_VALUE = 'Hello';
const TEXTAREA_ELEMENT = createElement('textarea', TEXTAREA_NAME, TEXTAREA_VALUE);

describe('createRequestBody', () => {
    it('returns request body when passed form field elements', () => {
        const requestBody = createRequestBody([INPUT_ELEMENT, TEXTAREA_ELEMENT]);

        expect(requestBody).toEqual({
            [TEST_INPUT_NAME]: TEST_INPUT_VALUE,
            [TEXTAREA_NAME]: TEXTAREA_VALUE,
        });
    });

    it('returns empty request body when passed no form field elements', () => {
        const requestBody = createRequestBody([]);

        expect(requestBody).toEqual({});
    });
});

function createElement(type: 'input' | 'textarea', name: string, value: string) {
    const element = document.createElement(type);

    element.name = name;
    element.value = value;

    return element;
}
