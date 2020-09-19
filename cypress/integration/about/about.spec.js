import * as strings from '../../strings';
import {
    MOBILE_VIEWPORT,
    TABLET_VIEWPORT,
    DESKTOP_VIEWPORT,
    ABOUT_INDEX_PATH,
} from '../../constants';

describe('About', () => {
    beforeEach(() => {
        cy.visit(ABOUT_INDEX_PATH);
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

    it('has page title', () => {
        cy.title().should('contain', strings.ABOUT_VIEW_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.ABOUT_VIEW_HEADING);
    });
});
