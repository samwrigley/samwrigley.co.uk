import './commands';
import './laravel-commands';

const environment = Cypress.env('environment');

before(() => {
    if (environment === 'local') {
        cy.exec('echo Testing...');
        cy.exec('./cypress/scripts/before');
    }

    cy.refreshDatabase({ '--seeder': 'DatabaseTestSeeder' });
});

after(() => {
    if (environment === 'local') {
        cy.exec('./cypress/scripts/after');
    }
});
