import { handleForm } from './handleForm';
import { screen, fireEvent, waitFor } from '@testing-library/dom';
import {
    URL,
    INPUT_NAME,
    INPUT_VALUE,
    SUCCESS_RESPONSE_MESSAGE_TEXT,
    FAILURE_RESPONSE_MESSAGE_TEXT,
    getCsrfMetaTagHtml,
} from '../tests';
import { ERROR_CLASS_NAME, HIDDEN_CLASS_NAME } from './displayFeedback';

const FORM_ID = 'form';
const FEEDBACK_ID = 'feedback';
const CUSTOM_FEEDBACK_ID = 'custom-feedback';
const SUBMIT_BUTTON_TEXT = 'Submit';

const FORM = `
<form data-testid="${FORM_ID}" action="${URL}" method="POST">
    <input type="text" name="${INPUT_NAME}" value="${INPUT_VALUE}" />
    <button type="submit">${SUBMIT_BUTTON_TEXT}</button>
    <div id="${FEEDBACK_ID}"></div>
</form>
`;

const FORM_WITH_CUSTOM_FEEDBACK_ID = `
<form data-testid="${FORM_ID}" action="${URL}" method="POST">
    <input type="text" name="${INPUT_NAME}" value="${INPUT_VALUE}" />
    <button type="submit">${SUBMIT_BUTTON_TEXT}</button>
    <div id="${CUSTOM_FEEDBACK_ID}"></div>
</form>
`;

describe('handleForm', () => {
    beforeEach(() => {
        document.head.innerHTML = '';
        document.body.innerHTML = '';
    });

    it('handles successful form submission', async () => {
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

    it('handles unsuccessful form submission', async () => {
        document.body.innerHTML = FORM;

        const formElement = screen.getByTestId(FORM_ID) as HTMLFormElement;

        handleForm(formElement);

        fireEvent.click(screen.getByText(SUBMIT_BUTTON_TEXT));

        const feedbackElement = await waitFor(() =>
            screen.getByText(FAILURE_RESPONSE_MESSAGE_TEXT)
        );

        expect(feedbackElement).toBeInTheDocument();
        expect(feedbackElement).toHaveClass(ERROR_CLASS_NAME);
        expect(feedbackElement).not.toHaveClass(HIDDEN_CLASS_NAME);
    });

    it('handles custom feedback element ID', async () => {
        document.head.innerHTML = getCsrfMetaTagHtml();
        document.body.innerHTML = FORM_WITH_CUSTOM_FEEDBACK_ID;

        const formElement = screen.getByTestId(FORM_ID) as HTMLFormElement;

        handleForm(formElement, CUSTOM_FEEDBACK_ID);

        fireEvent.click(screen.getByText(SUBMIT_BUTTON_TEXT));

        const feedbackElement = await waitFor(() =>
            screen.getByText(SUCCESS_RESPONSE_MESSAGE_TEXT)
        );

        expect(feedbackElement).toBeInTheDocument();
    });
});
