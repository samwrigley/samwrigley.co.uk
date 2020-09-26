import './commands';
import './laravel-commands';

const environment = Cypress.env('environment');

before(() => {
    cy.exec('echo Testing...');

    if (environment === 'local') {
        cy.exec('./cypress/scripts/before');
        cy.refreshDatabase({ '--seeder': 'DatabaseTestSeeder' });
    } else if (environment === 'ci') {
        cy.exec('./cypress/scripts/ci/before');
    }
});

after(() => {
    if (environment === 'local') {
        cy.exec('./cypress/scripts/after');
    }
});
