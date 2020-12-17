module.exports = {
  lintOnSave: false,
  devServer: {
    proxy:{
      '/api': {
        target: "http://www.321go.top:2001",
        ws: true,
        changeOrigin: true,
        pathRewrite: {
          '^/api': '/', // rewrite path
        },
      },
    }
  },
}