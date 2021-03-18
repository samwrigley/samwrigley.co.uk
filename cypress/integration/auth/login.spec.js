import * as strings from '../../strings';
import { ADMIN_DASHBOARD_PATH, DESKTOP_VIEWPORT, LOGIN_PATH, TEST_USER_EMAIL, TEST_USER_PASSWORD } from '../../constants';
import { LOGIN_FORM_ID } from '../../selectors';

describe('Login', () => {
    beforeEach(() => {
        cy.exec('php artisan migrate:fresh --seed');
        cy.visit(LOGIN_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().matchImageSnapshot();
    });

    it('has page title', () => {
        cy.title().should('contain', strings.LOGIN_VIEW_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.LOGIN_VIEW_HEADING);
    });

    it('has required email field', () => {
        cy.get(LOGIN_FORM_ID)
            .findByLabelText(strings.LOGIN_FORM_EMAIL_FIELD_LABEL)
            .should('have.attr', 'required');
    });

    it('has required password field', () => {
        cy.get(LOGIN_FORM_ID)
            .findByLabelText(strings.LOGIN_FORM_PASSWORD_FIELD_LABEL)
            .should('have.attr', 'required');
    });

    it('requires valid email and password', () => {
        cy.get(LOGIN_FORM_ID)
            .findByLabelText(strings.LOGIN_FORM_EMAIL_FIELD_LABEL)
            .type('invalid-email@example.com');
        cy.get(LOGIN_FORM_ID)
            .findByLabelText(strings.LOGIN_FORM_PASSWORD_FIELD_LABEL)
            .type('password');
        cy.get(LOGIN_FORM_ID).findByRole('button').click();
        cy.url().should('include', LOGIN_PATH);
        cy.get(LOGIN_FORM_ID).findByText(strings.LOGIN_FORM_INVALID_MESSAGE).should('exist');
    });

    it('redirects to admin dashboard after successful login', () => {
        cy.get(LOGIN_FORM_ID)
            .findByLabelText(strings.LOGIN_FORM_EMAIL_FIELD_LABEL)
            .type(TEST_USER_EMAIL);
        cy.get(LOGIN_FORM_ID)
            .findByLabelText(strings.LOGIN_FORM_PASSWORD_FIELD_LABEL)
            .type(TEST_USER_PASSWORD);
        cy.get(LOGIN_FORM_ID).findByRole('button').click();
        cy.url().should('include', ADMIN_DASHBOARD_PATH);
    });
});
