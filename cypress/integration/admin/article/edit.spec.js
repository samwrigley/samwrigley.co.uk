import * as strings from '../../../strings';
import { ADMIN_ARTICLE_EDIT_PATH, DESKTOP_VIEWPORT, TEST_ARTICLE_ID } from '../../../constants';

const TEST_ARTICLE_EDIT_PATH = ADMIN_ARTICLE_EDIT_PATH.replace('{article}', TEST_ARTICLE_ID);

describe('Admin Article Edit', () => {
    beforeEach(() => {
        cy.login();
        cy.visit(TEST_ARTICLE_EDIT_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });

    it('has page title', () => {
        cy.title().should('contain', strings.ADMIN_ARTICLE_EDIT_VIEW_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.ADMIN_ARTICLE_EDIT_VIEW_HEADING);
    });
});
