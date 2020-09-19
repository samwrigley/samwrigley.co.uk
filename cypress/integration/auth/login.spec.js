import * as strings from '../../strings';
import { ADMIN_DASHBOARD_PATH, DESKTOP_VIEWPORT, LOGIN_PATH } from '../../constants';
import { LOGIN_FORM_ID } from '../../selectors';

describe('Login', () => {
    beforeEach(() => {
        cy.visit(LOGIN_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });

    it('has page title', () => {
        cy.title().should('contain', strings.LOGIN_PAGE_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.LOGIN_PAGE_HEADING);
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
            .type('test@example.com');
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
            .type('sam@samwrigley.co.uk');
        cy.get(LOGIN_FORM_ID)
            .findByLabelText(strings.LOGIN_FORM_PASSWORD_FIELD_LABEL)
            .type('secret');
        cy.get(LOGIN_FORM_ID).findByRole('button').click();
        cy.url().should('include', ADMIN_DASHBOARD_PATH);
    });
});
