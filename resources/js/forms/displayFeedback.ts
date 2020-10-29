interface FeedbackConfig {
    isError?: boolean;
}

export const ERROR_CLASS_NAME = 'text-red-700';
export const HIDDEN_CLASS_NAME = 'hidden';

export function displayFeedback(
    wrapperElement: HTMLElement,
    feedback: string,
    config: FeedbackConfig = {}
) {
    if (config.isError) wrapperElement.classList.add(ERROR_CLASS_NAME);
    wrapperElement.innerHTML = feedback;
    wrapperElement.classList.remove(HIDDEN_CLASS_NAME);
}
