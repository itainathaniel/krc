
require('./bootstrap');

Vue.component('faces', require('./components/Faces.vue'));
Vue.component('member', require('./components/Member.vue'));

const app = new Vue({
    el: '#app'
});
