
import Vue from 'vue'
import axios from 'axios'

axios.defaults.baseURL = 'http://telsparv.appsj.ru/phonebooks' 
import PhoneBookParent from './components/PhoneBookParent.vue'

import SearchPhoneBooks from './components/SearchPhoneBooks.vue'
import SearchCustomers from './components/SearchCustomers.vue'
import SearchUsers from './components/SearchUsers.vue'

import vClickOutside from 'v-click-outside'

Vue.use(vClickOutside)

const App = new Vue({
    el: '#app',
    components: {
      'phone-book-parent': PhoneBookParent,
      'search-phone-books': SearchPhoneBooks,
      'search-customers': SearchCustomers,
      'search-users': SearchUsers,
    },
   
});
