import Base from '@/helpers/modules/base.js'

export default {
    mixins: [Base],

    data(){
        return {
            movieBaseUrl: "v1/admin/manage-movie",
        }
    },
    
    methods: {
        fetchAllMovie(params = {}){
            return this.processGetRequest(this.movieBaseUrl, params);
        },
        generateNewMovieApi(params = {},headers= {}, uploadProgressMethod = null){
            return this.processPostRequest(this.movieBaseUrl, params, headers, uploadProgressMethod);
        },
        showMovieApi(id = null , params = {}){
            return this.processGetRequest(this.movieBaseUrl + id, params );
        },
        updateMovieApi(params = {},theatreId = 0, headers= {}, uploadProgressMethod = null){
            params._method = 'put';
            return this.processPostRequest(this.movieBaseUrl+theatreId, params, headers, uploadProgressMethod);
        },
        deleteMovieApi(theatreId = null, params = {}){
            return this.processDeleteRequest(this.movieBaseUrl+theatreId,  params);
        },
        fetchMovieDetailFrontEnd(id = null , params = {}){
            return this.processGetRequest('v1/movie-detail/' + id, params );
        }
    } 
}