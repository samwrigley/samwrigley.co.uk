import { getFormFieldElements } from './getFormFieldElements';

const FORM_ID = 'form';
const INPUT_ID = 'input';
const TEXTAREA_ID = 'textarea';

const FORM_WITH_FIELDS_HTML = `
<form id="${FORM_ID}">
    <input type="text" id="${INPUT_ID}" />
    <textarea id="${TEXTAREA_ID}"></textarea>
</form>
`;

const FORM_WITHOUT_FIELDS_HTML = `
    <form id="${FORM_ID}">
        <div>No fields</div>
    </form>
`;

describe('getFormFieldElements', () => {
    it('returns array of form field elements', () => {
        document.body.innerHTML = FORM_WITH_FIELDS_HTML;

        const formElement = document.getElementById(FORM_ID) as HTMLFormElement;
        const inputElement = document.getElementById(INPUT_ID) as HTMLInputElement;
        const textareaElement = document.getElementById(TEXTAREA_ID) as HTMLTextAreaElement;
        const elements = getFormFieldElements(formElement);

        expect(elements).toHaveLength(2);
        expect(elements[0]).toEqual(inputElement);
        expect(elements[1]).toEqual(textareaElement);
    });

    it('returns empty array when form contains no fields', () => {
        document.body.innerHTML = FORM_WITHOUT_FIELDS_HTML;

        const formElement = document.getElementById(FORM_ID) as HTMLFormElement;
        const elements = getFormFieldElements(formElement);

        expect(elements).toHaveLength(0);
    });
});
