import * as strings from '../../strings';
import {
    BLOG_INDEX_PATH,
    DESKTOP_VIEWPORT,
    MOBILE_VIEWPORT,
    TABLET_VIEWPORT,
} from '../../constants';

describe('Blog Index', () => {
    beforeEach(() => {
        cy.exec('php artisan migrate:fresh --seed');
        cy.visit(BLOG_INDEX_PATH);
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
        cy.title().should('contain', strings.BLOG_INDEX_VIEW_TITLE);
    });
});
