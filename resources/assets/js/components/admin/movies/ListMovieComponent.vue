<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <router-link class="pull-right" to="/admin-panel/movies/add">Add Movie</router-link>
            </div>
            <div class="col-md-12">
                <div class="well">
                    <table v-infinite-scroll="fetchMovies" infinite-scroll-disabled="stop" infinite-scroll-distance="10"  class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Movie</th>
                            <th>Genre</th>
                            <th>Releasing Date</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-bind:key="index" v-for="(movie,index) in movies">
                            <td>{{movie.movie_name}}</td>
                            <td>{{movie.genre}}</td>
                            <td>{{movie.releasing_date}}</td>
                            <td>{{movie.description}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import MovieMixins from '@/helpers/modules/movie/movie.js'
import infiniteScroll from 'vue-infinite-scroll'
import _ from 'lodash'
export default {
    mixins:[MovieMixins],
    directives: {infiniteScroll},
    data(){
        return {
            movies: [],
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
        fetchMovies : _.debounce(
        function fetchMovies(){
        this.fetchAllMovie({
            page: this.pagination.currentPage + 1,
            per_page: 10
        })
        .then(response => {

            let movies = response.data.data;

            if(!movies.length){
                this.stop = true;
            }

            for (let movie of movies) {
                this.movies.push(movie);
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