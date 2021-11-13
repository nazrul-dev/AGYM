const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode : "jit",
    presets: [

        require('./vendor/ph7jack/wireui/tailwind.config.js')
    ],
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/ph7jack/wireui/resources/**/*.blade.php',
        './vendor/ph7jack/wireui/ts/**/*.ts',
        './vendor/ph7jack/wireui/src/View/**/*.php'
    ],

    theme: {
        container: {
            padding: {
              DEFAULT: '1rem',
              sm: '2rem',
              lg: '2rem',
              xl: '2rem',
              '2xl': '6rem',
            },
          },
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },


};
