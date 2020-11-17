import { handleForm } from './forms';

(function () {
    const formIds = ['contact', 'newsletter'];

    formIds.forEach((formId) => {
        const formElement = document.getElementById(formId) as HTMLFormElement | null;
        if (formElement) handleForm(formElement);
    });
})();
