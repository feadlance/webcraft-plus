window._ = require('lodash');

/**
 * Sweetalert
 */

window.swal = require('sweetalert2');

/**
 * Select 2
 */
window.select2 = require('select2');

$(function () {
	$('.select2').select2({
		width: '100%'
	});

	$('.select2-image').select2({
		width: '100%',
		templateResult: sl2AddIcon,
		templateSelection: sl2AddIcon
	});
});

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
var VueResource = require('vue-resource');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', WebcraftPlus.csrfToken);

    next();
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });