import * as strings from '../../strings';
import { CONTACT_FORM_ID } from '../../selectors';
import { TABLET_VIEWPORT, DESKTOP_VIEWPORT, CONTACT_INDEX_PATH } from '../../constants';

describe('Contact', () => {
    beforeEach(() => {
        cy.visit(CONTACT_INDEX_PATH);
    });

    it('matches tablet screenshot', () => {
        cy.viewport(TABLET_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });

    it('has page title', () => {
        cy.title().should('contain', strings.CONTACT_PAGE_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.CONTACT_PAGE_HEADING);
    });

    it('has required name field', () => {
        cy.get(CONTACT_FORM_ID)
            .findByLabelText(strings.CONTACT_FORM_NAME_FIELD_LABEL)
            .should('have.attr', 'required');
    });

    it('has required email field', () => {
        cy.get(CONTACT_FORM_ID)
            .findByLabelText(strings.CONTACT_FORM_EMAIL_FIELD_LABEL)
            .should('have.attr', 'required');
    });

    it('has required message field', () => {
        cy.get(CONTACT_FORM_ID)
            .findByLabelText(strings.CONTACT_FORM_MESSAGE_FIELD_LABEL)
            .should('have.attr', 'required');
    });

    it('cannot submit empty form', () => {
        cy.get(CONTACT_FORM_ID).findByRole('button').click();
        cy.findByText(strings.CONTACT_FORM_SUCCESS_MESSAGE).should('not.exist');
    });

    it('cannot submit invalid email', () => {
        cy.get(CONTACT_FORM_ID).findByLabelText(strings.CONTACT_FORM_NAME_FIELD_LABEL).type('Test');
        cy.get(CONTACT_FORM_ID)
            .findByLabelText(strings.CONTACT_FORM_EMAIL_FIELD_LABEL)
            .type('invalid-email');
        cy.get(CONTACT_FORM_ID)
            .findByLabelText(strings.CONTACT_FORM_MESSAGE_FIELD_LABEL)
            .type('Test');
        cy.get(CONTACT_FORM_ID).findByRole('button').click();
        cy.findByText(strings.CONTACT_FORM_SUCCESS_MESSAGE).should('not.exist');
    });

    it('can see success message on successful form submission', () => {
        cy.get(CONTACT_FORM_ID).findByLabelText(strings.CONTACT_FORM_NAME_FIELD_LABEL).type('Test');
        cy.get(CONTACT_FORM_ID)
            .findByLabelText(strings.CONTACT_FORM_EMAIL_FIELD_LABEL)
            .type('test@example.com');
        cy.get(CONTACT_FORM_ID)
            .findByLabelText(strings.CONTACT_FORM_MESSAGE_FIELD_LABEL)
            .type('Test');
        cy.get(CONTACT_FORM_ID).findByRole('button').click();
        cy.findByText(strings.CONTACT_FORM_SUCCESS_MESSAGE).should('exist');
    });
});
