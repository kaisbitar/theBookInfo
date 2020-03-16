const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');
   mix.disableSuccessNotifications();
 

   mix.js('resources/js/app.js', 'public/js')
    .webpackConfig({
         module: {
            rules: [
               // SASS has different line endings than SCSS
               // and cannot use semicolons in the markup
               {
                  test: /\.sass$/,
                  use: [
                  'vue-style-loader',
                  'css-loader',
                  {
                     loader: 'sass-loader',
                     // Requires sass-loader@^7.0.0
                     options: {
                        // This is the path to your variables
                        data: "@import '@/saas/variables.scss'"
                     },
                     // Requires sass-loader@^8.0.0
                     options: {
                        // This is the path to your variables
                        prependData: "@import '@/saas/variables.scss'"
                     },
                  },
                  ],
               },
               // SCSS has different line endings than SASS
               // and needs a semicolon after the import.
               // {
               //    test: /\.scss$/,
               //    use: [
               //    'vue-style-loader',
               //    'css-loader',
               //    {
               //       loader: 'sass-loader',
               //       // Requires sass-loader@^7.0.0
               //       options: {
               //          // This is the path to your variables
               //          data: "@import '@/sass/variables.scss';"
               //       },
               //       // Requires sass-loader@^8.0.0
               //       options: {
               //          // This is the path to your variables
               //          prependData: "@import '@/sass/variables.scss';"
               //       },
               //    },
               //    ],
               // },
            ],
      }, resolve: {
        alias: {
          '@': path.resolve('resources/sass')
        }
      }
   })
   .sass('resources/sass/app.scss', 'public/css');

   
   // stlyus
   // mix.stylus('resources/stylus/app.styl', 'public/css');
