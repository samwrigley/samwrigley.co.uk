import { ADMIN_DASHBOARD_PATH, DESKTOP_VIEWPORT } from '../../constants';

describe('Admin Dashboard', () => {
    beforeEach(() => {
        cy.login();
        cy.visit(ADMIN_DASHBOARD_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });
});
