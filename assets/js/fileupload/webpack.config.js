var webpack = require('webpack');
var path = require('path');
const TerserPlugin = require("terser-webpack-plugin");

var BUILD_DIR = path.resolve(__dirname, 'public');
var APP_DIR = path.resolve(__dirname, 'src/app');


var configFileUp = {
    entry: APP_DIR + '/fileupload.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-fileupload.js'
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
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
    }
};
var configPregunta = {
    entry: APP_DIR + '/preguntas.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-preguntas.js'
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.js|\.jsx?/,
                include: APP_DIR,
                exclude: /node_modules/,
                loader: ['babel-loader']
            },
            {
                test: /\.css$/i,
                use: ['style-loader', 'css-loader'],
            },
        ]
    }
};

var configIncidencias = {
    entry: APP_DIR + '/incidencias.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-incidencias.js'
    },
    resolve: {
        extensions: [".js", ".jsx"]
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.(js|jsx)$/,
                // include: APP_DIR,
                exclude: /node_modules/,
                use: "babel-loader",
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            },
        ]
    },
};

var configFilePreview = {
    entry: APP_DIR + '/filepreview.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-preview.js'
    },
    resolve: {
        extensions: [".js", ".jsx"]
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.(js|jsx)$/,
                // include: APP_DIR,
                exclude: /node_modules/,
                use: "babel-loader",
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            },
        ]
    },
};

var configCompetencias = {
    entry: APP_DIR + '/competencias.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-competencias.js'
    },
    performance: {
        hints: false,
        maxAssetSize: 1000
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.js|\.jsx?/,
                include: APP_DIR,
                exclude: /node_modules/,
                loader: ['babel-loader']
            },
            {
                test: /\.css$/i,
                use: ['style-loader', 'css-loader'],
            },
        ]
    }
};

var configEvaluacion = {
    entry: APP_DIR + '/evaluaciones.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-evaluaciones.js',
    },
    resolve: {
        extensions: [".js", ".jsx"]
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.(js|jsx)$/,
                // include: APP_DIR,
                exclude: /node_modules/,
                use: "babel-loader",
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            },
        ]
    },
};

var configPersona = {
    entry: APP_DIR + '/personas.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-personas.js',
    },
    mode: 'production',
    resolve: {
        extensions: [".js", ".jsx"]
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.(js|jsx)$/,
                // include: APP_DIR,
                exclude: /node_modules/,
                use: "babel-loader",
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            },
        ]
    },
};

var configEvaluacionConfig = {
    entry: APP_DIR + '/evaluaciones_configurar.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-evaluaciones-config.js',
    },
    resolve: {
        extensions: [".js", ".jsx"]
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.(js|jsx)$/,
                // include: APP_DIR,
                exclude: /node_modules/,
                use: "babel-loader",
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            },
        ]
    },
};



var configPIP = {
    entry: APP_DIR + '/pip.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-pip.js',
    },
    resolve: {
        extensions: [".js", ".jsx"]
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.(js|jsx)$/,
                // include: APP_DIR,
                exclude: /node_modules/,
                use: "babel-loader",
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            },
        ]
    },
};



var configMonitoreo = {
    entry: APP_DIR + '/monitoreoPIP.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-monitoreoPIP.js',
    },
    resolve: {
        extensions: [".js", ".jsx"]
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()]
    },
    module: {
        rules: [{
                test: /\.(js|jsx)$/,
                // include: APP_DIR,
                exclude: /node_modules/,
                use: "babel-loader",
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            },
        ]
    },
};

var configEvaluacionPeriodo = {
    entry: APP_DIR + '/evaluacion_periodo.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-evaluacion-periodo.js',
        library: 'bundlewebaluacionperiodo',
        libraryTarget: 'umd',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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


var configFiltro = {
    entry: APP_DIR + '/modal_filtro.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-modal-filtro.js',
        library: 'bundlemodalfiltro',
        libraryTarget: 'umd',
    },
    mode: "production",
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            terserOptions: {
                parse: {
                    // we want terser to parse ecma 8 code. However, we don't want it
                    // to apply any minfication steps that turns valid ecma 5 code
                    // into invalid ecma 5 code. This is why the 'compress' and 'output'
                    // sections only apply transformations that are ecma 5 safe
                    // https://github.com/facebook/create-react-app/pull/4234
                    ecma: 8
                },
                compress: {
                    ecma: 5,
                    warnings: false,
                    // Disabled because of an issue with Uglify breaking seemingly valid code:
                    // https://github.com/facebook/create-react-app/issues/2376
                    // Pending further investigation:
                    // https://github.com/mishoo/UglifyJS2/issues/2011
                    comparisons: false,
                    // Disabled because of an issue with Terser breaking valid code:
                    // https://github.com/facebook/create-react-app/issues/5250
                    // Pending futher investigation:
                    // https://github.com/terser-js/terser/issues/120
                    inline: 2
                },
                mangle: {
                    safari10: true
                },
                output: {
                    ecma: 5,
                    comments: false,
                    // Turned on because emoji and regex is not minified properly using default
                    // https://github.com/facebook/create-react-app/issues/2488
                    ascii_only: true
                }
            },
            cache: true,
            parallel: true,
            sourceMap: true, // Must be set to true if using source-maps in production
        })]
    },
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
var configModalDetail = {
    entry: APP_DIR + '/modal_detail.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-modal-detalle.js',
        library: 'bundlemodaldetalle',
        libraryTarget: 'umd',
    },
    mode: "production",
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            terserOptions: {
                parse: {
                    ecma: 8
                },
                compress: {
                    ecma: 5,
                    warnings: false,
                    comparisons: false,
                    inline: 2
                },
                mangle: {
                    safari10: true
                },
                output: {
                    ecma: 5,
                    comments: false,
                    ascii_only: true
                }
            },
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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

var configModalliberar = {
    entry: APP_DIR + '/modalperiodo.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-modalperiodo.js',
    },
    mode: "production",
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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
var configModalSeguimiento = {
    entry: APP_DIR + '/modal_seguimiento.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-modal-seguimiento.js',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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

var configModalAutorizacion = {
    entry: APP_DIR + '/modal_autorizacion.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-modal-autorizacion.js',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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

var configBonos = {
    entry: APP_DIR + '/bonos.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-bonos.js',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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

var configTabuladorBonos = {
    entry: APP_DIR + '/tabuladorbono.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-tabuladorbono.js',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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

var configSiniestros = {
    entry: APP_DIR + '/siniestros.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-siniestros.js',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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

var configAseguradora = {
    entry: APP_DIR + '/Aseguradoraws.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-aseguradoraws.js',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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

var configCliente = {
    entry: APP_DIR + '/cliente-ejecutivo.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-cliente-ejecutivo.js',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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

var configPermisos = {
    entry: APP_DIR + '/permisos.js',
    output: {
        path: BUILD_DIR,
        filename: 'bundle-permisos.js',
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            cache: true,
            parallel: true,
            sourceMap: true,
        })]
    },
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


module.exports=[configModalliberar,configEvaluacionPeriodo];
//module.exports=[configBonos,configCliente,configCompetencias,configEvaluacion,configEvaluacionPeriodo,configIncidencias,configFiltro,configModalliberar,configModalSeguimiento,configPermisos,configPregunta,configTabuladorBonos];
// module.exports = [configEvaluacionPeriodo, configCompetencias,configPIP,configMonitoreo];
//
//module.exports = [/* configModalliberar *//* configIncidencias *//* configModalliberar *//* configBonos *//* configModalSeguimiento *//* configTabuladorBonos *//* configFiltro *//* configEvaluacionPeriodo *//* configEvaluacion *//* configCompetencias *//* configPregunta *//* configPIP,configMonitoreo *//* configPermisos *//* configEvaluacionPeriodo *//* configSiniestros *//* ,configAseguradora, *//* configCliente */];
// module.exports = [configEvaluacion, configPersona, configFileUp, configFilePreview, configEvaluacionPeriodo, configPregunta, configIncidencias, configCompetencias];