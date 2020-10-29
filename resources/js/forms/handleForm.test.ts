import { handleForm } from './handleForm';
import { screen, fireEvent, waitFor } from '@testing-library/dom';
import {
    URL,
    INPUT_NAME,
    INPUT_VALUE,
    SUCCESS_RESPONSE_MESSAGE_TEXT,
    getCsrfMetaTagHtml,
} from '../tests';
import { ERROR_CLASS_NAME, HIDDEN_CLASS_NAME } from './displayFeedback';

const FORM_ID = 'form';
const SUBMIT_BUTTON_TEXT = 'Submit';

const FORM = `
<form data-testid="${FORM_ID}" action="${URL}" method="POST">
    <input type="text" name="${INPUT_NAME}" value="${INPUT_VALUE}" />
    <button type="submit">${SUBMIT_BUTTON_TEXT}</button>
    <div id="feedback"></div>
</form>
`;

describe('handleForm', () => {
    it('handles form submision', async () => {
        document.head.innerHTML = getCsrfMetaTagHtml();
        document.body.innerHTML = FORM;

        const formElement = screen.getByTestId(FORM_ID) as HTMLFormElement;

        handleForm(formElement);

        fireEvent.click(screen.getByText(SUBMIT_BUTTON_TEXT));

        const feedbackElement = await waitFor(() =>
            screen.getByText(SUCCESS_RESPONSE_MESSAGE_TEXT)
        );

        expect(feedbackElement).toBeInTheDocument();
        expect(feedbackElement).not.toHaveClass(ERROR_CLASS_NAME);
        expect(feedbackElement).not.toHaveClass(HIDDEN_CLASS_NAME);
    });
});
