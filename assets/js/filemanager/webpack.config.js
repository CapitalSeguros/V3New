var webpack = require('webpack');
var path = require('path');
const TerserPlugin = require("terser-webpack-plugin");

var BUILD_DIR = path.resolve(__dirname, 'public');
var APP_DIR = path.resolve(__dirname, 'src/');

var configfilemanager = {
    entry: APP_DIR + '/filemanager.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle.js',
    },
    // optimization: {
    //     minimize: true,
    //     minimizer: [new TerserPlugin({
    //         cache: true,
    //         parallel: true,
    //         sourceMap: true,
    //     })]
    // },
    module: {
        rules: [{
                test: /\.js|\.jsx?/,
                exclude: /(node_modules|bower_components)/,
                loader: 'babel-loader',
                options: {
                    presets: ['@babel/preset-env', '@babel/react']
                }
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    },
};

// module.exports = [configEvaluacionPeriodo, configCompetencias,configPIP,configMonitoreo];
//
module.exports = [configfilemanager];
// module.exports = [configEvaluacion, configPersona, configFileUp, configFilePreview, configEvaluacionPeriodo, configPregunta, configIncidencias, configCompetencias];