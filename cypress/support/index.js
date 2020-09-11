import './commands';
import './laravel-commands';

before(() => {
    cy.exec('echo test');
    cy.exec('./cypress/pre-run', { failOnNonZeroExit: false });
});

after(() => {});
cy.exec('./cypress/post-run', { failOnNonZeroExit: false });
