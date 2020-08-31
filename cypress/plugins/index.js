const { initPlugin } = require('cypress-plugin-snapshots/plugin');

module.exports = (on, config) => {
    initPlugin(on, config);
    on('task', require('./swap-env'));

    return config;
};
