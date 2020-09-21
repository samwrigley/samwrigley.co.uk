import * as strings from '../../strings';
import {
    ADMIN_ARTICLE_CREATE_PATH,
    ADMIN_ARTICLE_INDEX_PATH,
    ADMIN_DASHBOARD_PATH,
    BLOG_INDEX_PATH,
    DESKTOP_VIEWPORT,
} from '../../constants';

describe('Admin Dashboard', () => {
    beforeEach(() => {
        cy.login();
        cy.visit(ADMIN_DASHBOARD_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().toMatchImageSnapshot();
    });

    it('has page title', () => {
        cy.title().should('contain', strings.DASHBOARD_VIEW_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.DASHBOARD_VIEW_HEADING);
    });

    describe('Topbar', () => {
        it('can logout', () => {
            cy.findByText(strings.LOGOUT_BUTTON_TEXT).click();
            cy.url().should('include', BLOG_INDEX_PATH);
        });
    });

    describe('Sidebar', () => {
        it('can navigate to article index view', () => {
            cy.findByText(strings.ALL_ARTICLE_LINK_TEXT).click();
            cy.url().should('include', ADMIN_ARTICLE_INDEX_PATH);
        });

        it('can navigate to article create view', () => {
            cy.findByText(strings.CREATE_ARTICLE_LINK_TEXT).click();
            cy.url().should('include', ADMIN_ARTICLE_CREATE_PATH);
        });
    });
});
