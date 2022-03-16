let Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('./src/Resources/public/')
    .setPublicPath('/')
    .setManifestKeyPrefix('bundles/coralmediapetclinic')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .copyFiles({
        from: './assets/',
            // to: 'desktop/[path][name].[hash:8].[ext]'
        to: '[path][name].[ext]'
    })
module.exports = Encore.getWebpackConfig();
