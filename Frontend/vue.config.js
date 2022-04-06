module.exports = {
  devServer: {
    port: 8081,
    proxy: {
      "/api": {
        target: "http://127.0.0.1:3005",
        secure: false
      },
      "/admin-api": {
        target: "http://127.0.0.1:3005",
        secure: false
      }
    }
  },
}