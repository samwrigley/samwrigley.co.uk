import './commands';
import './laravel-commands';
import './assertions';

before(() => {
    cy.task('activateCypressEnvFile', {}, { log: false });
});

after(() => {
    cy.task('activateLocalEnvFile', {}, { log: false });
});
