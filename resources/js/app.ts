import { handleForm } from './forms';

(function () {
    const formElements = Array.from(document.getElementsByTagName('form'));

    formElements.forEach((formElement) => {
        if (formElement.id) handleForm(formElement.id);
    });
})();
