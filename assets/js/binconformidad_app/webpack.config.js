const $path = require("path");
const NodePolyfillPlugin = require('node-polyfill-webpack-plugin');

module.exports = [
    {
        entry: __dirname + "/src/binconformidad.js",
        //target: 'node',
        output: {
            filename: "bundle.inconformidad.js",
            path: __dirname + "/bundle",
        },
        module: {
            rules: [
                {
                    test: /\.css$/,
                    use: ["style-loader", "css-loader"]
                }
            ]
        },
        plugins: [
            new NodePolyfillPlugin()
        ],
    },
];

//module.exports = exports;