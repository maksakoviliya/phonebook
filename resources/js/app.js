
import Vue from 'vue'
import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:3000' 
import PhoneBookParent from './components/PhoneBookParent.vue'

import SearchPhoneBooks from './components/SearchPhoneBooks.vue'

import vClickOutside from 'v-click-outside'

Vue.use(vClickOutside)

const App = new Vue({
    el: '#app',
    components: {
      'phone-book-parent': PhoneBookParent,
      'search-phone-books': SearchPhoneBooks
    },
   
});
