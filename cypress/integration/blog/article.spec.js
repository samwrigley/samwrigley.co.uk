import {
    BLOG_INDEX_PATH,
    DESKTOP_VIEWPORT,
    MOBILE_VIEWPORT,
    TABLET_VIEWPORT,
} from '../../constants';

const TEST_ARTICLE_SHOW_PATH = BLOG_INDEX_PATH + 'test';

describe('Blog Article Index', () => {
    beforeEach(() => {
        cy.visit(TEST_ARTICLE_SHOW_PATH);
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
