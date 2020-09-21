import * as strings from '../../../strings';
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

    it('has page title', () => {
        cy.title().should('contain', strings.ADMIN_ARTICLE_EDIT_VIEW_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.ADMIN_ARTICLE_EDIT_VIEW_HEADING);
    });

    it('can delete article', () => {
        //
    });

    it('can update title', () => {
        //
    });

    it('can update slug', () => {
        //
    });

    it('can update excerpt', () => {
        //
    });

    it('can update body', () => {
        //
    });

    it('can update publish date', () => {
        //
    });

    it('can update publish time', () => {
        //
    });

    it('can update categories', () => {
        //
    });

    it('can update series', () => {
        //
    });

    it('can remove categories', () => {
        //
    });

    it('can remove series', () => {
        //
    });

    it('can set aticle to draft', () => {
        //
    });

    it('can remove excerpt', () => {
        //
    });

    it('requires title', () => {
        //
    });

    it('requires slug', () => {
        //
    });

    it('requires alpha dash slug', () => {
        //
    });

    it('requires body', () => {
        //
    });
});
