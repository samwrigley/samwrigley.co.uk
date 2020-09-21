import { ADMIN_ARTICLE_EDIT_PATH, DESKTOP_VIEWPORT, TEST_ARTICLE_ID } from '../../../constants';

describe('Admin Article Edit', () => {
    beforeEach(() => {
        cy.login();
        cy.visit(ADMIN_ARTICLE_EDIT_PATH.replace('{article}', TEST_ARTICLE_ID));
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });
});
