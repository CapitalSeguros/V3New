
const ruta = require("path");

{
    module.exports = [
        {   //capacitacion manual
            entry: __dirname + "/src/Capacitaciones.js",
            output: {
                filename: "bundle-capacitaciones.js",
                path: __dirname + "/bundle_js"
            },
            module: {
                rules: [
                    {
                        test: /\.js|\.jsx?/,
                        exclude: /(node_modules|bower_components)/,
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env', '@babel/react']
                        }
                    }
                ]
            }
        },
        {   //Reporte de capacitación
            entry: __dirname + "/src/ReporteCapacitacion.js",
            output: {
                filename: "bundle-reporteCapacitacion.js",
                path: __dirname + "/bundle_js"
            },
            module: {
                rules: [
                    {
                        test: /\.js|\.jsx?/,
                        exclude: /(node_modules|bower_components)/,
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env', '@babel/react']
                        }
                    }
                ]
            }
        }
    ]
}