const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin")
const CopyPlugin = require('copy-webpack-plugin')

const assets_dir = path.resolve(__dirname, 'assets')
const js_dir = path.resolve(__dirname, 'assets/src/js')
const ico_dir = path.resolve(__dirname, 'assets/src/icons')
const lib_dir = path.resolve(__dirname, 'assets/src/vendor')
const build_dir = path.resolve(__dirname, 'assets/build')

const entry = {
    frontend: js_dir + '/frontend.js',
    admin: js_dir + '/admin.js',
}

const output = {
    path: build_dir,
    filename: 'js/[name].bundle.js', // [name].bundle_[contenthash].js
    clean: true, // clean previous js files
    assetModuleFilename: '[path][name][ext]', // Keep the image file name
}

const plugins = [
    new MiniCssExtractPlugin({
        filename: 'css/[name].css'
    }),

    new CopyPlugin({
        patterns: [
            { from: lib_dir, to: assets_dir + '/vendor' }
        ]
    }),
];

const rules = [
    {
        test: /\.js$/,
        include: [js_dir],
        exclude: /node_modules/,
        use: {
            loader: 'babel-loader',
            options: {
                presets: ['@babel/preset-env']
            }
        }
    },
    {
        test: /\.(s[ac]|c)ss$/,
        exclude: /node_modules/,
        use: [
            MiniCssExtractPlugin.loader,
            {
                loader: 'css-loader',
                options: { importLoaders: 1 },
            },
            {
                loader: 'postcss-loader',
                options: {
                    postcssOptions: {
                        plugins: [
                            [
                                'autoprefixer'
                            ],
                        ],
                    },
                },
            },
            'sass-loader'
        ]
    },
    {
        test: /\.(png|jpg|svg|jpeg|gif|ico)$/,
        type: 'asset/resource',
        generator: {
            filename: 'images/[name][ext]'
        }
    },
    {
        test: /\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
        exclude: [ico_dir, /node_modules/],
        type: 'asset/resource',
        generator: {
            filename: 'fonts/[name][ext]'
        }
    }
]

module.exports = (env) => ({

    watch: 'development' === process.env.NODE_ENV ? true : false,

    entry: entry,
    output: output,

    devtool: 'development' === process.env.NODE_ENV ? 'source-map' : false,

    plugins: plugins,

    module: {
        rules: rules,
    },

    externals: {
        jquery: 'jQuery'
    },

})