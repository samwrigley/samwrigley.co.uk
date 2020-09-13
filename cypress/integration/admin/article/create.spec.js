import { ADMIN_ARTICLE_CREATE_PATH, DESKTOP_VIEWPORT } from '../../../constants';

describe('Admin Article Create', () => {
    beforeEach(() => {
        cy.login();
        cy.visit(ADMIN_ARTICLE_CREATE_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });
});
