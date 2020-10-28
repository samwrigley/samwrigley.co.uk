import { handleForm } from './handleForm';
import { screen, fireEvent, waitFor } from '@testing-library/dom';
import { TEST_URL, TEST_RESPONSE_MESSAGE_TEXT } from '../tests';

const FORM_TEST_ID = 'form';
const FORM_ACTION_URL = TEST_URL;
const INPUT_NAME = 'name';
const INPUT_VALUE = 'Sam';
const SUBMIT_BUTTON_TEXT = 'Submit';

const FORM = `
<form data-testid="${FORM_TEST_ID}" action="${FORM_ACTION_URL}" method="POST">
    <input type="text" name="${INPUT_NAME}" value="${INPUT_VALUE}" />
    <button type="submit">${SUBMIT_BUTTON_TEXT}</button>
    <div id="feedback"></div>
</form>
`;

describe('handleForm', () => {
    it('handles form submision', async () => {
        document.body.innerHTML = FORM;

        const formElement = screen.getByTestId(FORM_TEST_ID) as HTMLFormElement;

        handleForm(formElement);

        fireEvent.click(screen.getByText(SUBMIT_BUTTON_TEXT));

        const feedbackElement = await waitFor(() => screen.getByText(TEST_RESPONSE_MESSAGE_TEXT));

        expect(feedbackElement).toBeInTheDocument();
    });
});
