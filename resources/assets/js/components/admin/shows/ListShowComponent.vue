<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <router-link class="pull-right" to="/admin-panel/shows/add">Add Show</router-link>
            </div>
            <div class="col-md-12">
                <div class="well">
                    <table v-infinite-scroll="fetchShows" infinite-scroll-disabled="stop" infinite-scroll-distance="10"  class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Movie</th>
                            <th>Theatre</th>
                            <th>Slot</th>
                            <th>Total Seats</th>
                            <th>Booked Seats</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-bind:key="index" v-for="(show,index) in shows">
                            <td>{{show.movie.movie_name}}</td>
                            <td>{{show.theatre.theatre_name}}</td>
                            <td>{{show.time_slot.time_slot}}</td>
                            <td>{{show.total_seats}}</td>
                            <td>{{show.booked_seats}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ShowMixins from '@/helpers/modules/show/show.js'
import infiniteScroll from 'vue-infinite-scroll'
import _ from 'lodash'
export default {
    mixins:[ShowMixins],
    directives: {infiniteScroll},
    data(){
        return {
            shows: [],
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
        fetchShows : _.debounce(
        function fetchShows(){
        this.fetchAllShowsListApi({
            page: this.pagination.currentPage + 1,
            per_page: 10
        })
        .then(response => {

            let shows = response.data.data;

            if(!shows.length){
                this.stop = true;
            }

            for (let show of shows) {
                this.shows.push(show);
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