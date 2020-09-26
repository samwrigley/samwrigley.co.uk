import './commands';
import './laravel-commands';

const environment = Cypress.env('environment');

before(() => {
    if (environment === 'local') {
        cy.task('swapCypressEnvFile', {}, { log: false });
    }
});

after(() => {
    if (environment === 'local') {
        cy.task('swapLocalEnvFile', {}, { log: false });
    }
});
