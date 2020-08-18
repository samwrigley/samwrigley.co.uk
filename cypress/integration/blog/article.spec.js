import * as strings from '../../strings';
import { NEWSLETTER_FORM_ID } from '../../selectors';
import {
    BLOG_INDEX_PATH,
    DESKTOP_VIEWPORT,
    MOBILE_VIEWPORT,
    TABLET_VIEWPORT,
} from '../../constants';

const TEST_ARTICLE_SHOW_PATH = BLOG_INDEX_PATH + 'test';

describe('Blog Article Index', () => {
    beforeEach(() => {
        cy.visit(TEST_ARTICLE_SHOW_PATH);
    });

    it('matches mobile screenshot', () => {
        cy.viewport(MOBILE_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });

    it('matches tablet screenshot', () => {
        cy.viewport(TABLET_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });

    describe('Newsletter', () => {
        it('cannot submit form without email', () => {
            cy.get(NEWSLETTER_FORM_ID).findByRole('button').click();
            cy.findByText(strings.NEWSLETTER_FORM_SUCCESS_MESSAGE).should('not.exist');
        });

        it('cannot subscribe using invalid email', () => {
            cy.get(NEWSLETTER_FORM_ID)
                .findByLabelText(strings.NEWSLETTER_FORM_FIELD_LABEL)
                .type('invalid-email');
            cy.get(NEWSLETTER_FORM_ID).findByRole('button').click();
            cy.get(NEWSLETTER_FORM_ID)
                .findByText(strings.NEWSLETTER_FORM_FAILURE_MESSAGE)
                .should('exist');
        });

        it('cannot subscribe if email is already subscribed', () => {
            cy.get(NEWSLETTER_FORM_ID)
                .findByLabelText(strings.NEWSLETTER_FORM_FIELD_LABEL)
                .type('invalid-email');
            cy.get(NEWSLETTER_FORM_ID).findByRole('button').click();
            cy.get(NEWSLETTER_FORM_ID)
                .findByText(strings.NEWSLETTER_FORM_ALREADY_SUBSCRIBED_MESSAGE)
                .should('exist');
        });

        it('can see success message on successful subscription', () => {
            cy.get(NEWSLETTER_FORM_ID)
                .findByLabelText(strings.NEWSLETTER_FORM_FIELD_LABEL)
                .type('test@example.com');
            cy.get(NEWSLETTER_FORM_ID).findByRole('button').click();
            cy.get(NEWSLETTER_FORM_ID)
                .findByText(strings.NEWSLETTER_FORM_SUCCESS_MESSAGE)
                .should('exist');
        });
    });
});
