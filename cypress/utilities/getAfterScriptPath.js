export const getAfterScriptPath = () => {
    const environment = Cypress.env('environment');

    return `./cypress/scripts/${environment}/after`;
};

export default getAfterScriptPath;
