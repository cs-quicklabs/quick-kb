import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
	safelist: [
		{
		  pattern: /(^|\s)(bg|hover:bg|focus:ring|focus:border|dark:bg|dark:hover:bg|dark:focus:ring|text|hover:text|dark:text|dark:hover:text)-(red|blue|teal|green|yellow|orange)-(50|100|200|300|400|500|600|700|800|900)(\s|$)/,
		},
	],
	  
	  
    theme: {
        extend: {colors: {
			primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
		  }},
    },
    fontFamily: {
		'body': [
			'Inter',
			'ui-sans-serif',
			'system-ui',
			'-apple-system',
			'system-ui',
			'Segoe UI',
			'Roboto',
			'Helvetica Neue',
			'Arial',
			'Noto Sans',
			'sans-serif',
			'Apple Color Emoji',
			'Segoe UI Emoji',
			'Segoe UI Symbol',
			'Noto Color Emoji'
		],
		'sans': [
			'Inter',
			'ui-sans-serif',
			'system-ui',
			'-apple-system',
			'system-ui',
			'Segoe UI',
			'Roboto',
			'Helvetica Neue',
			'Arial',
			'Noto Sans',
			'sans-serif',
			'Apple Color Emoji',
			'Segoe UI Emoji',
			'Segoe UI Symbol',
			'Noto Color Emoji'
		]
	},
    plugins: [
        //require('flowbite-typography')
    ],
};
