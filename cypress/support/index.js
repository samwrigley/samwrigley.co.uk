import './commands';
import './laravel-commands';

before(() => {
    cy.exec('php artisan key:generate');
});

after(() => {});
