let fs = require('fs');

module.exports = {
    swapCypressEnvFile() {
        if (fs.existsSync('.env.cypress')) {
            fs.renameSync('.env', '.env.backup');
            fs.renameSync('.env.cypress', '.env');
        }

        return null;
    },

    swapLocalEnvFile() {
        if (fs.existsSync('.env.backup')) {
            fs.renameSync('.env', '.env.cypress');
            fs.renameSync('.env.backup', '.env');
        }

        return null;
    },
};
