import './commands';
import './laravel-commands';

const environment = Cypress.env('environment');

before(() => {
    if (environment === 'local') {
        cy.task('swapCypressEnvFile', {}, { log: false });
        cy.refreshDatabase({ '--seeder': 'Database\\Seeders\\Test\\TestSeeder' });
    }
});

after(() => {
    if (environment === 'local') {
        cy.task('swapLocalEnvFile', {}, { log: false });
    }
});
