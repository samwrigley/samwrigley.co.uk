import './commands';
import './laravel-commands';

const ENV = Cypress.env('environment');
const DATABASE_SEEDER = 'Database\\Seeders\\Test\\TestSeeder';

before(() => {
    if (ENV === 'local') {
        cy.task('swapCypressEnvFile', {}, { log: false });
        cy.refreshDatabase({ '--seeder': DATABASE_SEEDER });
    }
});

after(() => {
    if (ENV === 'local') {
        cy.task('swapLocalEnvFile', {}, { log: false });
    }
});
