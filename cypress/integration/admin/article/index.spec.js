import * as strings from '../../../strings';
import {
    ADMIN_ARTICLE_EDIT_PATH,
    ADMIN_ARTICLE_INDEX_PATH,
    DESKTOP_VIEWPORT,
    TEST_ARTICLE_ID,
    TEST_ARTICLE_TITLE,
} from '../../../constants';

describe('Admin Article Index', () => {
    beforeEach(() => {
        cy.exec('php artisan migrate:fresh --seed');
        cy.login();
        cy.visit(ADMIN_ARTICLE_INDEX_PATH);
    });

    it('matches desktop screenshot', () => {
        cy.viewport(DESKTOP_VIEWPORT);
        cy.document().matchImageSnapshot();
    });

    it('has page title', () => {
        cy.title().should('contain', strings.ADMIN_ARTICLE_INDEX_VIEW_TITLE);
    });

    it('has h1 heading', () => {
        cy.get('h1').should('contain', strings.ADMIN_ARTICLE_INDEX_VIEW_HEADING);
    });

    it('can navigate to article edit view', () => {
        cy.findByText(TEST_ARTICLE_TITLE).click();
        cy.url().should('include', ADMIN_ARTICLE_EDIT_PATH.replace('{article}', TEST_ARTICLE_ID));
    });
});
