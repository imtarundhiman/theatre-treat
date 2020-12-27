<style scoped>
    .jumbotron-popular-shows {
        background: transparent !important;
        text-align: center !important;
    }

    .panel-footer {
        padding: 5px !important;
    }
</style>

<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <!-- Jumbotron -->
                <div class="jumbotron jumbotron-popular-shows">
                <h1>My Bookings</h1>
                </div>
            </div>

            <div v-if="!bookings || !bookings.length" class="col-md-12">
                <!-- Jumbotron -->
                <div class="jumbotron jumbotron-popular-shows">
                <h2>You Dont Have any Past Booking.</h2>
                </div>
            </div>
        </div>

        <div v-infinite-scroll="fetchBookings" infinite-scroll-disabled="stop" infinite-scroll-distance="10" class="row">
            <div v-bind:key="index" v-for="(booking,index) in this.bookings" class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Booking id: {{booking.id}} 
                    </div>
                    <div class="panel-body">
                        {{booking.show.movie.movie_name}} at {{booking.show.theatre.theatre_name}} for {{booking.booked_seats}} People.
                    </div>
                    <div class="panel-footer">
                        <i class="fa fa-clock-o"></i> {{booking.show.show_date}} | {{booking.show.time_slot.time_slot}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BookingMixins from '@/helpers/modules/booking/booking.js'
import infiniteScroll from 'vue-infinite-scroll'
import _ from 'lodash'
export default {
    mixins: [BookingMixins],
    directives: {infiniteScroll},
    data(){
        return {
            bookings: [],
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
        fetchBookings : _.debounce(
        function fetchBookings(){
        this.showMyBookingsApi({
            page: this.pagination.currentPage + 1,
            per_page: 12
        })
        .then(response => {

            let bookings = response.data.data;

            if(!bookings.length){
                this.stop = true;
            }

            for (let booking of bookings) {
                this.bookings.push(booking);
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
}
</script>