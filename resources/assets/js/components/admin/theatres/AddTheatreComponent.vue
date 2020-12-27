<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="bs-example">
                    <h4>Add Theatre</h4>
                    <form class="well" @submit.prevent="saveTheatre">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="email">Theatre Name</label>
                                <input type="text" name="theatre_name" v-model="theatreName" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Total Seats</label>
                                <input type="number" name="total_seats" v-model="totalSeats"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pwd">Theatre Address</label>
                                <textarea name="theatre_address" v-model="theatreAddress" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Theatre Description</label>
                                <textarea name="theatre_description" v-model="theatreDescription" class="form-control" rows="3"></textarea>
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
export default {
    mixins: [TheatreMixins],
    data(){
        return{
            theatreName: "",
            theatreAddress: "",
            theatreDescription: "",
            totalSeats: ""
        }
    },

    methods: {
        saveTheatre(){
            $('.errors').empty();
            this.generateNewTheatreApi({
                'theatre_name' : this.theatreName,
                'theatre_address' : this.theatreAddress, 
                'theatre_description' : this.theatreDescription, 
                'total_seats' : this.totalSeats, 
            })
            .then(response=>{
                let business = response.data.data;
                this.$notify({
                    group: 'notifications',
                    text: response.data.message
                });
                this.$router.push('/admin-panel/theatres');
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

                $("*[name=error]").after(
                    '<span class="errors text-danger">' + errors[0] + "</span>"
                );
            })
        }
    }
}
</script>