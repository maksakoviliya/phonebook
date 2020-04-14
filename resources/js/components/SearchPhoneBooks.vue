<template>
  <div class="mr-auto ml-4 w-50">
    <form action="#" class="search-form">
      <div class="form-group">
        <label class="bmd-label-floating d-flex align-items-center"><i class="material-icons">search</i> Поиск по справочникам</label>
        <input type="text" class="form-control" v-model="search" v-click-outside="onClickOutside" @focus="show = true">
      </div>
      <div class="search-results" v-if="search">
        <ul class="list-unstyled mb-0" v-if="results.length > 0">
          <li v-for="result in results" :key="result.id">
            <a :href="path+result.id+'/edit'">{{ result.title }}</a>
          </li>
        </ul>
        <div v-else>
          <p class="mb-0 p-3">Результатов не найдено</p>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
  import axios from 'axios'
  import vClickOutside from 'v-click-outside'


  export default {
    props: {
      baseUrl: {
        default: 'http://localhost:3000'
      }
    },
    directives: {
      clickOutside: vClickOutside.directive
    },
    data() {
        return {
            search: null,
            results: [],
            show: false,
            path: ''
        };
    },

    watch: {
        search(after, before) {
            this.fetch();
        }
    },
    mounted() {
      this.path = this.baseUrl + '/phonebooks/'
    },
    methods: {
        fetch() {
            axios.get('/api/search/phonebooks', { params: { search: this.search } })
                .then((response) => {
                  this.results = response.data.phonebooks
                })
                .catch(error => {});
        },
        handleBlur() {
          this.show = false
          this.search = null
          this.results = []
        },
        onClickOutside (event) {
          this.handleBlur()
        }
    }
  }
</script>

<style lang="scss">
  .search-form{
    position: relative;
  }
  .search-results{
    background-color: rgba(#7b1fa2, .7);  
    position: absolute;
    left: 0;
    top: 100%;
    width: 100%; 
    border-radius: 3px;
    li{
      a{
        padding: 8px 16px; 
        display: block;
        &:hover{
          background-color: rgba(#7b1fa2, .7);
        }
      }
    }
  }
</style>