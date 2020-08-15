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
});
