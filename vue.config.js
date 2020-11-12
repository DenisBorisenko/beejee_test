const {resolve} = require('path')
const publicFolderPath = resolve(__dirname, 'public')
const frontendFolderPath = resolve(__dirname, 'resources/frontend')
const baseViewPath = resolve(__dirname, 'resources/views/spa.php')

module.exports = {
  outputDir: publicFolderPath,
  publicPath: '/',
  indexPath: baseViewPath,
  chainWebpack: config => {
    config
        .entry("app")
        .clear()
        .add("./resources/frontend/main.js")
        .end()
        .resolve
        .alias
        .set('@', frontendFolderPath)
  },
  devServer: {
    proxy: 'http://localhost:8888',
  },
  css: {
    loaderOptions: {
      sass: {
        prependData: `@import "~@/assets/scss/app.scss";`
      }
    }
  }


}
