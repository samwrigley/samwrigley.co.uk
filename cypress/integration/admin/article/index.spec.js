import { ADMIN_ARTICLE_INDEX_PATH, DESKTOP_VIEWPORT } from '../../../constants';

describe('Admin Article Index', () => {
    beforeEach(() => {
        cy.login();
        cy.visit(ADMIN_ARTICLE_INDEX_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });
});
