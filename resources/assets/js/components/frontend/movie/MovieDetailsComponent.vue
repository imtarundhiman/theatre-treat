<style scoped>

.occupied-panel {
    background: #ffcdd2 !important;
}

.panel-footer {
    padding: 5px !important;
}
.jumbotron-popular-shows {
    background: transparent !important;
    text-align: center !important;
}
.movie-image {
    padding: 20px;
}
    @media (min-width: 768px){
        .jumbotron {
            padding-top: calc(var(--jumbotron-padding-y) * 2);
            padding-bottom: calc(var(--jumbotron-padding-y) * 2);
        }
    }

    .jumbotron {
        background: #fff;
    }
</style>

<template>
    <div>
        <section class="jumbotron text-center">
            <div class="row">
                <div class="col-md-4">
                    <img v-if="movie.image" class="img-responsive movie-image" :src="movie.image.public_url" :alt="movie.movie_name">
                </div>
                <div class="col-md-8">
                    <h3 class="jumbotron-heading">{{movie.movie_name}}</h3>
                    <p class="lead text-muted">{{movie.description}}</p>
                    <p>
                        <a href="javascript:;" class="btn btn-secondary my-2">{{movie.genre}}</a>
                    </p>
                </div>
            </div>
        </section>


        <div class="row">
            <div v-if="!shows || !shows.length" class="col-md-12">
                <!-- Jumbotron -->
                <div class="jumbotron jumbotron-popular-shows">
                <h2>No Upcoming shows for this movie</h2>
                </div>
            </div>
            <div v-if="shows && shows.length" class="col-md-12">
                <!-- Jumbotron -->
                <div class="jumbotron jumbotron-popular-shows">
                <h2>Upcoming Shows</h2>
                </div>
            </div>
        </div>

        <div class="row"  v-infinite-scroll="fetchAllShows" infinite-scroll-disabled="stop" infinite-scroll-distance="10" >
        <div v-bind:key="index" v-for="(show,index) in this.shows" class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="text-success">{{show.show_date}}</span> |
                    <span class="text-primary">{{show.time_slot.time_slot}}</span>
                </div>
                <div class="panel-body">
                    <h4>{{show.theatre.theatre_name}}</h4>
                    <p>{{ show.theatre.theatre_address | strLimit(80)  }}</p>
                    <p>{{show.total_seats - show.booked_seats}} seats available from {{show.total_seats}} seats</p> 
                   
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="number" min="1" v-model="shows[index].required_seats" class="form-control" placeholder="Seats">
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-default" @click.prevent="bookTicket(index, show)"  role="button" href="javascript:;">Book</a>
                        </div>
                    </div>
                    
                </div>
            </div>
          
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->
    </div>
</template>

<script>
import MoviesMixins from '@/helpers/modules/movie/movie.js'
import ShowsMixins from '@/helpers/modules/show/show.js'
import BookingMixins from '@/helpers/modules/booking/booking.js'
import infiniteScroll from 'vue-infinite-scroll'
import _ from 'lodash'
export default {
    mixins: [MoviesMixins, ShowsMixins, BookingMixins],
    directives: {infiniteScroll},
    data(){
        return{
            movieId: null,
            movie: {
                id: null,
                movie_name: "",
                genre: "",
                description: "",
                releasing_date: "",
                image: null,
                shows:null
            },
            pagination: {
                total: 0,
                to: 0,
                currentPage: 0,
                previousPage: null,
                nextPage: 1,
                lastPage: null,
                from: 1
            },
            shows: [],
            stop: false
        }
    },

    mounted() {
        this.movieId = this.$route.params.movieId;

        this.fetchMovieDetails();
    },

    methods: {
        fetchMovieDetails(){
            this.fetchMovieDetailFrontEnd(this.movieId).then(response => {
                this.movie = response.data.data;
            })
        },
        bookTicket : _.debounce(
        function bookTicket(index, show){

            let required_seats = this.shows[index].required_seats;
            let show_id = show.id;

            let formData = new FormData;

            formData.append('required_seats', this.shows[index].required_seats)
            formData.append('show_id', show.id)

            this.bookTicketApi(formData)
            .then(response => {
                let result = response.data.data;

                let showData = result.showData;

                this.shows[index].booked_seats = showData.booked_seats;
                this.shows[index].required_seats = '';

                this.$notify({
                    group: 'notifications',
                    text: response.data.message
                });
            })
            .catch(error => {
                let errors = error.response.data;

                if(error.response.status == 422){
                    for (error in errors) {
                        $("*[name=" + error + "]").after(
                            '<span class="errors text-danger">' + errors[error] + "</span>"
                        );

                        this.$notify({
                            group: 'error',
                            text:  errors[error][0]
                        });
                    }

                
                return;
                }

                this.$notify({
                    group: 'error',
                    text:  errors[0]
                });
            })
        }, 500),
        fetchAllShows : _.debounce(
      function fetchAllShows(){
      this.fetchShowsByMovieApi(this.movie.id,{
        page: this.pagination.currentPage + 1,
        per_page: 12
      })
      .then(response => {

        let shows = response.data.data;

        if(!shows.length){
          this.stop = true;
        }

        for (let show of response.data.data) {
          show.required_seats = "";
          show.booked_seats = (show.booked_seats)? show.booked_seats: 0;
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
    },
    filters: {
    strLimit: function(value, size) {
      if (!value) return '';
      value = value.toString();

      if (value.length <= size) {
        return value;
      }
      return value.substr(0, size) + '...';
    }
  }
}
</script>