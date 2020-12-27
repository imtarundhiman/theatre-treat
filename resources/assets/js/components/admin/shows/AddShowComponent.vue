<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="bs-example">
                    <h4>Add Show Schedule</h4>
                    <form class="well" @submit.prevent="saveMovie">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Movie</label>
                                <select name="movie" class="form-control" v-model="movie">
                                    <option disabled value="">Please select one</option>
                                    <option :value="movie.id" v-bind:key="index" v-for="(movie,index) in movies">{{movie.movie_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Theatre</label>
                                <select name="theatre" class="form-control" v-model="theatre">
                                    <option disabled value="">Please select one</option>
                                    <option :value="theatre.id" v-bind:key="index" v-for="(theatre,index) in theatres">{{theatre.theatre_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pwd">Slot</label>
                                <select name="slot" class="form-control" v-model="slot">
                                    <option disabled value="">Please select one</option>
                                    <option :value="slot.id" v-bind:key="index" v-for="(slot,index) in slots">{{slot.time_slot}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Show Date</label>
                                <input name="show_date" class="form-control" v-model="showDate" type="date">
                            </div>
                           
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TheatreMixins from '@/helpers/modules/theatre/theatre.js'
import MovieMixins from '@/helpers/modules/movie/movie.js'
import SlotMixins from '@/helpers/modules/slot/slot.js'
import ShowMixins from '@/helpers/modules/show/show.js'
export default {
    mixins: [TheatreMixins,MovieMixins,SlotMixins,ShowMixins],
    data(){
        return{
            movie: '',
            theatre: '',
            slot: '',
            showDate: '',
            movies:[],
            theatres: [],
            slots: []
        }
    },

    mounted(){
        this.fetchMovies();
        this.fetchTheatres();
        this.fetchSlots();
    },
    methods: {
        fetchMovies(){
            this.fetchAllMovie({
                'nopaging': true
            })
            .then(response=> {
                this.movies = response.data.data;
            })
        },
        fetchTheatres(){
            this.fetchAllTheatre({
                'nopaging': true
            })
            .then(response=> {
                this.theatres = response.data.data;
            })
        },
        fetchSlots(){
            this.fetchAllSlot({
                'nopaging': true
            })
            .then(response=> {
                this.slots = response.data.data;
            })
        },
        saveMovie(){
            $('.errors').empty();

            let formData = new FormData();

            formData.append('movie', this.movie);
            formData.append('theatre', this.theatre);
            formData.append('slot', this.slot);
            formData.append('show_date', this.showDate);
            this.generateNewShowApi(formData)
            .then(response=>{
                let business = response.data.data;
                this.$notify({
                    group: 'notifications',
                    text: response.data.message
                });
                this.$router.push('/admin-panel/shows');
            })
            .catch(error=>{
                let errors = error.response.data;

                if(error.response.status == 422){
                for (error in errors) {
                    $("*[name=" + error + "]").after(
                        '<span class="errors text-danger">' + errors[error] + "</span>"
                    );
                }
                return;
                }

                this.$notify({
                    group: 'error',
                    text:  errors[0]
                });
            })
        }
    }
}
</script>