export const getBeforeScriptPath = () => {
    const environment = Cypress.env('environment');

    return `./cypress/scripts/${environment}/before`;
};

export default getBeforeScriptPath;
