<template>
    <div v-click-outside="onClickOutside">
        <input type="text" name="parent_id" v-model="selectedItem.id" hidden="">
        <div class="parent-select">
            <div class="parent-select__input mt-2" @click="openList">
                {{ selectedItem.title }}
            </div>
            <div class="parent-select__list" v-if="showList">
                <ul class="list-unstyled">
                    <li v-for="phonebook in phonebooks" :key="phonebook.id">
                        <a href="#" class="mb-2" @click.prevent="fetch(phonebook)">
                            <span @click.prevent="setSelectedItem(phonebook)"><i class="material-icons">done</i></span>
                              {{phonebook.title}}</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center justify-content-center pb-2">
                    <a href="#" class="toStart" @click.prevent="fetch({id: 0})"><i class="material-icons">keyboard_arrow_left</i> В начало</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import vClickOutside from 'v-click-outside'

    export default {
        props: {
            initialId: {
                default: 0
            },
            initialTitle: {
                type: String,
                default: 'Самостоятельная организация'
            }
        },
        directives: {
          clickOutside: vClickOutside.directive
        },
        data () {
            return {
                phonebooks: [],
                selectedItem: {
                    id: null,
                    title: null
                },
                showList: false,
            }
        },
        mounted() {
            this.selectedItem.id = this.initialId
            this.selectedItem.title = this.initialTitle
            this.fetch(this.selectedItem)
        },
        methods: {
            fetch(phonebook) {
                console.log(phonebook);
                axios.get('/api/phonebooks/'+phonebook.id)
              .then(response => {
                if(! response.data.phonebooks.length) {
                    this.setSelectedItem(phonebook)
                }
                this.phonebooks = response.data.phonebooks
              })
              .catch((e)=>{
                console.log(e);
              })
            },
            setSelectedId(id) {
                this.selectedId = id
            },
            openList() {
                this.fetch({id: 0})
                this.showList = true
            },
            hideList() {
                this.showList = false
            },
            setSelectedItem(phonebook) {
                this.hideList()
                this.selectedItem = phonebook
            },
            onClickOutside (event) {
              this.hideList()
            }
        }
    }
</script>

<style lang="scss">
    .parent-select{
        position: relative;
        z-index: 99;
        .parent-select__input{
            cursor: pointer;
            border-bottom: 1px solid  #d2d2d2;
            padding: 0.4375rem 0;
        }
        .parent-select__list{
            position: absolute;
            background-color: #202940;
            width: 100%;
            left: 0;
            top: calc(100% + 6px);
            z-index: 99;
            .toStart{
                display: inline-block;
                padding-left: 16px;
                &:hover{
                    background-color: #202940;
                    color: #9c27b0;
                }
            }
            a{
                padding: 8px 16px 8px 40px;
                position: relative;
                width: 100%;
                display: block;
                &.active,
                &:hover{
                    background-color: #9c27b0;
                }
                span{
                    position: absolute;
                    left: 8px;
                    top: 7px;
                    width: 26px;
                    height: 26px;
                    display: block;
                    font-size: 21px;
                    &:hover{
                        background-color: darken(#9c27b0, 15%);
                    }
                }
            }
        }
    }
</style>