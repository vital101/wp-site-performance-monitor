/** @type {import("snowpack").SnowpackUserConfig } */
const webpack = require('webpack');
module.exports = {
  mount: {
    public: '/',
    src: '/_dist_',
  },
  plugins: [
    '@snowpack/plugin-svelte',
    '@snowpack/plugin-dotenv',
    [
      '@snowpack/plugin-webpack',
      {
        extendConfig: config => {
          config.plugins.push(
            new webpack.optimize.LimitChunkCountPlugin({
              maxChunks: 1
            })
          );
          return config;
        }
      }
    ]
  ]
};
