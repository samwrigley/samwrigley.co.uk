const { addMatchImageSnapshotPlugin } = require('cypress-image-snapshot/plugin');

module.exports = (on, config) => {
    addMatchImageSnapshotPlugin(on, config);
    on('task', require('./env'));

    return config;
};
