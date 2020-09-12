import './commands';
import './laravel-commands';
import { getBeforeScriptPath, getAfterScriptPath } from '../utilities';

const BEFORE_SCRIPT_PATH = getBeforeScriptPath();
const AFTER_SCRIPT_PATH = getAfterScriptPath();

before(() => {
    cy.exec('echo test');
    cy.exec(BEFORE_SCRIPT_PATH, { failOnNonZeroExit: false });
});

after(() => {
    cy.exec(AFTER_SCRIPT_PATH, { failOnNonZeroExit: false });
});
