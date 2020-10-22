export function getFormFieldElements(formElement: HTMLFormElement) {
    const inputElements = Array.from(formElement.getElementsByTagName('input'));
    const textareaElements = Array.from(formElement.getElementsByTagName('textarea'));

    return [...inputElements, ...textareaElements];
}
