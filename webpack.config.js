const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    entry: {
        style: './private/scss/style.scss',
        main: './private/ts/index.ts',  // Entry point for TypeScript
    },
    output: {
        path: path.resolve(__dirname, 'public'),  // Output directory for JS and CSS
        filename: 'js/[name].js',  // Output filename pattern for JS
    },
    module: {
        rules: [
            {
                test: /\.scss$/,  // Target SCSS files
                use: [
                    MiniCssExtractPlugin.loader,  // Extracts CSS into separate file
                    'css-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.tsx?$/,  // Target TypeScript files
                use: 'ts-loader',
                exclude: /node_modules/,
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',  // Output CSS file name
        }),
    ],
    resolve: {
        extensions: ['.js', '.ts', '.tsx', '.scss'],  // Resolve these extensions
    },
    devtool: 'source-map',  // Enable source maps for easier debugging
};
