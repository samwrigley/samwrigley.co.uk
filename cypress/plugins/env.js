let fs = require('fs');

module.exports = {
    swapCypressEnvFile() {
        if (fs.existsSync('.env.testing')) {
            fs.renameSync('.env', '.env.backup');
            fs.renameSync('.env.testing', '.env');
        }

        return null;
    },

    swapLocalEnvFile() {
        if (fs.existsSync('.env.backup')) {
            fs.renameSync('.env', '.env.testing');
            fs.renameSync('.env.backup', '.env');
        }

        return null;
    },
};
