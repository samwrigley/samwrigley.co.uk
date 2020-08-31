import './commands';
import './laravel-commands';

before(() => {
    cy.task('activateCypressEnvFile', {}, { log: false });
});

after(() => {
    cy.task('activateLocalEnvFile', {}, { log: false });
});
