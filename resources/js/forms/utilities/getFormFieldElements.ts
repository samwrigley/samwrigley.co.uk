export function getFormFieldElements(form: HTMLFormElement) {
    const inputs = Array.from(form.getElementsByTagName('input'));
    const textareas = Array.from(form.getElementsByTagName('textarea'));

    return [...inputs, ...textareas];
}
