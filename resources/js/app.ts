import { handleForm } from './forms';

(function () {
    const forms = Array.from(document.getElementsByTagName('form'));

    forms.forEach((form) => {
        if (form.id) handleForm(form.id);
    });
})();
