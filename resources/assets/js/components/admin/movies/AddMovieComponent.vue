<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="bs-example">
                    <h4>Add Movie</h4>
                    <form class="well" @submit.prevent="saveMovie">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="email">Movie Name</label>
                                <input type="text" name="movie_name" v-model="movieName" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Genre</label>
                                <input type="text" name="genre" v-model="genre"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pwd">Release Date</label>
                                <input type="date" name="releasing_date" v-model="releasingDate"  class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Description</label>
                                <textarea name="description" v-model="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Movie Image</label>
                                <input ref="movie_image" class="form-control" type="file" name="file">
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
import TheatreMixins from '@/helpers/modules/movie/movie.js'
export default {
    mixins: [TheatreMixins],
    data(){
        return{
            movieName: "",
            genre: "",
            description: "",
            releasingDate: "",
            uploadedFiles: [],
            uploadFieldName: 'attached_files',
        }
    },

    methods: {
        saveMovie(){
            $('.errors').empty();

            let formData = new FormData();

            formData.append('file', this.$refs.movie_image.files.length ? this.$refs.movie_image.files[0] : '');

            formData.append('movie_name', this.movieName);
            formData.append('genre', this.genre);
            formData.append('description', this.description);
            formData.append('releasing_date', this.releasingDate);
            this.generateNewMovieApi(formData, {
                "Content-type" : "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
            }, (progressEvent) => {
                this.showFileUploadProgres = true;
                this.fileUploadProgress = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
            })
            .then(response=>{
                let business = response.data.data;
                this.$notify({
                    group: 'notifications',
                    text: response.data.message
                });
                this.$router.push('/admin-panel/movies');
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