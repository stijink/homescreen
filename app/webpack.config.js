const Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('assets/')

    // public path used by the web server to access the output path
    .setPublicPath('/assets')

    .addEntry('app', './src/main.js')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableVueLoader()
;

module.exports = Encore.getWebpackConfig();