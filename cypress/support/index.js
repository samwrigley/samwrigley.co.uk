import * as strings from '../strings';
import { LOGIN_PATH, TEST_USER_EMAIL, TEST_USER_PASSWORD } from '../constants';
import { LOGIN_FORM_ID } from '../selectors';

import './commands';

Cypress.Commands.add('login', () => {
    cy.visit(LOGIN_PATH);
    cy.get(LOGIN_FORM_ID)
        .findByLabelText(strings.LOGIN_FORM_EMAIL_FIELD_LABEL)
        .type(TEST_USER_EMAIL);
    cy.get(LOGIN_FORM_ID)
        .findByLabelText(strings.LOGIN_FORM_PASSWORD_FIELD_LABEL)
        .type(TEST_USER_PASSWORD);
    cy.get(LOGIN_FORM_ID).findByRole('button').click();
});
