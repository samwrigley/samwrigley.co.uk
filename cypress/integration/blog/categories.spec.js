import * as strings from '../../strings';
import {
    BLOG_CATEGORIES_INDEX_PATH,
    DESKTOP_VIEWPORT,
    MOBILE_VIEWPORT,
    TABLET_VIEWPORT,
} from '../../constants';

describe('Blog Categories Index', () => {
    beforeEach(() => {
        cy.visit(BLOG_CATEGORIES_INDEX_PATH);
    });

    it('matches mobile screenshot', () => {
        cy.viewport(MOBILE_VIEWPORT);
        cy.document().matchImageSnapshot();
    });

    it('matches tablet screenshot', () => {
        cy.viewport(TABLET_VIEWPORT);
        cy.document().matchImageSnapshot();
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().matchImageSnapshot();
    });

    it('has page title', () => {
        cy.title().should('contain', strings.BLOG_CATEGORIES_INDEX_VIEW_TITLE);
    });
});
