import { handleForm } from './forms';

(function () {
    const formElements = Array.from(document.getElementsByTagName('form'));

    formElements.forEach((formElement) => handleForm(formElement));
})();
