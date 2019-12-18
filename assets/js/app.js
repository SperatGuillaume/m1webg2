/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import 'bootstrap/dist/css/bootstrap.min.css';
require('../css/app.css');
require('../admin-theme/vendor/fontawesome-free/css/all.min.css');
require('../admin-theme/css/sb-admin-2.min.css');


import 'bootstrap';
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

global.$ = global.jQuery = $;


require('../admin-theme/vendor/jquery/jquery.min.js');
require('../admin-theme/vendor/bootstrap/js/bootstrap.bundle.min.js');
require('../admin-theme/vendor/jquery-easing/jquery.easing.min.js');
require('../admin-theme/js/sb-admin-2.min.js');
require('../admin-theme/vendor/datatables/jquery.dataTables.min.js');
require('../admin-theme/vendor/datatables/dataTables.bootstrap4.min.js');
require('../admin-theme/js/demo/datatables-demo.js');
//require('../admin-theme/vendor/chart.js/Chart.min.js');
//require('../admin-theme/js/demo/chart-area-demo.js');
//require('../admin-theme/js/demo/chart-pie-demo.js');









console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
