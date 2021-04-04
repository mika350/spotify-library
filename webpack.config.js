const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/assets/')
    .setPublicPath('/assets/')

    .addEntry('app', './assets/js/all.js')

    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]',
    })

    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()

    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
