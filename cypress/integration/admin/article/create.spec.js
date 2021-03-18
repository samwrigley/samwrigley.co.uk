import * as strings from '../../../strings';
import { ARTICLE_CREATE_FORM_ID } from '../../../selectors';
import { ADMIN_ARTICLE_CREATE_PATH, DESKTOP_VIEWPORT } from '../../../constants';

describe('Admin Article Create', () => {
    beforeEach(() => {
        cy.exec('php artisan migrate:fresh --seed');
        cy.login();
        cy.visit(ADMIN_ARTICLE_CREATE_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().matchImageSnapshot();
    });

    it('has page title', () => {
        cy.title().should('contain', strings.ADMIN_ARTICLE_CREATE_VIEW_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.ADMIN_ARTICLE_CREATE_VIEW_HEADING);
    });

    it('requires title', () => {
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_TITLE_FIELD_LABEL)
            .should('have.attr', 'required');
    });

    it('requires slug', () => {
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_SLUG_FIELD_LABEL)
            .should('have.attr', 'required');
    });

    it('requires alpha dash slug', () => {
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_TITLE_FIELD_LABEL)
            .type('Title');
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_SLUG_FIELD_LABEL)
            .type('Invalid Slug');
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_BODY_FIELD_LABEL)
            .type('Body');
        cy.get(ARTICLE_CREATE_FORM_ID).findByRole('button').click();
        cy.url().should('include', ADMIN_ARTICLE_CREATE_PATH);
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findAllByText(strings.ARTICLE_CREATE_FORM_INVALID_SLUG_MESSAGE)
            .should('have.length', 2);
    });

    it('requires body', () => {
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_BODY_FIELD_LABEL)
            .should('have.attr', 'required');
    });

    it('cannot use a taken title or slug', () => {
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_TITLE_FIELD_LABEL)
            .type('Test');
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_SLUG_FIELD_LABEL)
            .type('test');
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_BODY_FIELD_LABEL)
            .type('Body');
        cy.get(ARTICLE_CREATE_FORM_ID).findByRole('button').click();
        cy.url().should('include', ADMIN_ARTICLE_CREATE_PATH);
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findAllByText(strings.ARTICLE_CREATE_FORM_TAKEN_TITLE_MESSAGE)
            .should('have.length', 2);
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findAllByText(strings.ARTICLE_CREATE_FORM_TAKEN_SLUG_MESSAGE)
            .should('have.length', 2);
    });

    it('can create article', () => {
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_TITLE_FIELD_LABEL)
            .type('Title');
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_SLUG_FIELD_LABEL)
            .type('slug');
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByLabelText(strings.ARTICLE_CREATE_FORM_BODY_FIELD_LABEL)
            .type('Body');
        cy.get(ARTICLE_CREATE_FORM_ID).findByRole('button').click();
        cy.url().should('include', ADMIN_ARTICLE_CREATE_PATH);
        cy.get(ARTICLE_CREATE_FORM_ID)
            .findByText(strings.ARTICLE_CREATE_FORM_SUCCESS_MESSAGE)
            .should('exist');
    });
});
