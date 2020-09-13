import { ADMIN_ARTICLE_EDIT_PATH, DESKTOP_VIEWPORT } from '../../../constants';

describe('Admin Article Edit', () => {
    beforeEach(() => {
        cy.login();
        cy.visit(ADMIN_ARTICLE_EDIT_PATH.replace('{article}', '4'));
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });
});
