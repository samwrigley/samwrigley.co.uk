interface FeedbackConfig {
    isError?: boolean;
}

export function displayFeedback(
    wrapperElement: HTMLElement,
    feedback: string,
    config: FeedbackConfig = {}
) {
    if (config.isError) wrapperElement.classList.add('text-red-700');
    wrapperElement.innerHTML = feedback;
    wrapperElement.classList.remove('hidden');
}
