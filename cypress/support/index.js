import './commands';
import './laravel-commands';

before(() => {
    cy.task('activateCypressEnvFile', {}, { log: false });
    cy.exec('php artisan key:generate');
});

after(() => {
    cy.task('activateLocalEnvFile', {}, { log: false });
});
