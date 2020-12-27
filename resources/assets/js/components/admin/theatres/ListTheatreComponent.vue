<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <router-link class="pull-right" to="/admin-panel/theatres/add">Add Theatre</router-link>
            </div>
            <div class="col-md-12">
                <div class="well">
                    <table v-infinite-scroll="fetchTheatres" infinite-scroll-disabled="stop" infinite-scroll-distance="10"  class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Description</th>
                            <th>Total Seats</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-bind:key="index" v-for="(theatre,index) in theatres">
                            <td>{{theatre.theatre_name}}</td>
                            <td>{{theatre.theatre_address}}</td>
                            <td>{{theatre.theatre_description}}</td>
                            <td>{{theatre.total_seats}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import TheatreMixins from '@/helpers/modules/theatre/theatre.js'
import infiniteScroll from 'vue-infinite-scroll'
import _ from 'lodash'
export default {
    mixins:[TheatreMixins],
    directives: {infiniteScroll},
    data(){
        return {
            theatres: [],
            pagination: {
                total: 0,
                to: 0,
                currentPage: 0,
                previousPage: null,
                nextPage: 1,
                lastPage: null,
                from: 1
            },
            stop: false
        }
    },

    methods: {
        fetchTheatres : _.debounce(
        function fetchTheatres(){
        this.fetchAllTheatre({
            page: this.pagination.currentPage + 1,
            per_page: 10
        })
        .then(response => {

            let theatres = response.data.data;

            if(!theatres.length){
                this.stop = true;
            }

            for (let theatre of theatres) {
                this.theatres.push(theatre);
            }

            this.pagination.total = response.data.total;
            this.pagination.to = response.data.to;
            this.pagination.currentPage = response.data.current_page;
            this.pagination.previousPage = response.data.prev_page_url;
            this.pagination.nextPage = response.data.next_page_url;
            this.pagination.lastPage = response.data.last_page;
            this.pagination.from = response.data.from;
        })
        }, 500)
    }
}
</script>