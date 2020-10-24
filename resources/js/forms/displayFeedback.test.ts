import { displayFeedback } from './displayFeedback';
import '@testing-library/jest-dom';

const FEEDBACK_WRAPPER_ID = 'wrapper';
const HIDDEN_CLASS_NAME = 'hidden';
const ERROR_CLASS_NAME = 'text-red-700';
const FEEDBACK_TEXT = 'Feedback';

const FEEDBACK_WRAPPER_HTML = `<div id="${FEEDBACK_WRAPPER_ID}" class="${HIDDEN_CLASS_NAME}"></div>`;

describe('displayFeedback', () => {
    it('displays feedback text inside feedback wrapper element', () => {
        document.body.innerHTML = FEEDBACK_WRAPPER_HTML;

        const feedbackWrapperElement = document.getElementById(
            FEEDBACK_WRAPPER_ID
        ) as HTMLDivElement;

        displayFeedback(feedbackWrapperElement, FEEDBACK_TEXT);

        expect(feedbackWrapperElement).toHaveTextContent(FEEDBACK_TEXT);
    });

    it('removes hidden class from feedback wrapper element', () => {
        document.body.innerHTML = FEEDBACK_WRAPPER_HTML;

        const feedbackWrapperElement = document.getElementById(
            FEEDBACK_WRAPPER_ID
        ) as HTMLDivElement;

        expect(feedbackWrapperElement).toHaveClass(HIDDEN_CLASS_NAME);

        displayFeedback(feedbackWrapperElement, FEEDBACK_TEXT);

        expect(feedbackWrapperElement).not.toHaveClass(HIDDEN_CLASS_NAME);
    });

    it('does not add error class to feedback wrapper element by default', () => {
        document.body.innerHTML = FEEDBACK_WRAPPER_HTML;

        const feedbackWrapperElement = document.getElementById(
            FEEDBACK_WRAPPER_ID
        ) as HTMLDivElement;

        expect(feedbackWrapperElement).not.toHaveClass(ERROR_CLASS_NAME);

        displayFeedback(feedbackWrapperElement, FEEDBACK_TEXT);

        expect(feedbackWrapperElement).not.toHaveClass(ERROR_CLASS_NAME);
    });

    it('adds error class to feedback wrapper element if feedback is an error', () => {
        document.body.innerHTML = FEEDBACK_WRAPPER_HTML;

        const feedbackWrapperElement = document.getElementById(
            FEEDBACK_WRAPPER_ID
        ) as HTMLDivElement;

        expect(feedbackWrapperElement).not.toHaveClass(ERROR_CLASS_NAME);

        displayFeedback(feedbackWrapperElement, FEEDBACK_TEXT, { isError: true });

        expect(feedbackWrapperElement).toHaveClass(ERROR_CLASS_NAME);
    });
});
