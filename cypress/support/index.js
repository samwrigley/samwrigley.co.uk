import './commands';
import './laravel-commands';
import { getBeforeScriptPath, getAfterScriptPath } from '../utilities';

const BEFORE_SCRIPT_PATH = getBeforeScriptPath();
const AFTER_SCRIPT_PATH = getAfterScriptPath();

before(() => {
    cy.exec('echo Testing...');
    cy.exec(BEFORE_SCRIPT_PATH);
});

after(() => {
    cy.exec(AFTER_SCRIPT_PATH);
});
