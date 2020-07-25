import Vue from "vue";
import axios from "axios";

// axios.defaults.baseURL = 'http://localhost:3000/'
axios.defaults.baseURL = "http://telsparv.appsj.ru";
import PhoneBookParent from "./components/PhoneBookParent";

import SearchPhoneBooks from "./components/SearchPhoneBooks";
import SearchCustomers from "./components/SearchCustomers";
import SearchUsers from "./components/SearchUsers";
import SearchContacts from "./components/SearchContacts";
import AvatarInput from "./components/AvatarInput";

import vClickOutside from "v-click-outside";

Vue.use(vClickOutside);

const App = new Vue({
  el: "#app",
  components: {
    "phone-book-parent": PhoneBookParent,
    "search-phone-books": SearchPhoneBooks,
    "search-customers": SearchCustomers,
    "search-users": SearchUsers,
    "search-contacts": SearchContacts,
    "avatar-input": AvatarInput
  }
});
