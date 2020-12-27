import Base from '@/helpers/modules/base.js'

export default {
    mixins: [Base],

    data(){
        return {
            showBaseUrl: "v1/admin/manage-show",
        }
    },
    
    methods: {

        // frontend routes

        fetchAllShowsApi(params = {}){
            return this.processGetRequest("v1/fetch-shows", params);
        },
        fetchShowsByMovieApi(movieId, params = {}){
            return this.processGetRequest('v1/movie-detail/'+ movieId +'/fetch-shows' , params );
        },

        // backend routes

        generateNewShowApi(params = {}){
            return this.processPostRequest(this.showBaseUrl, params);
        },

        fetchAllShowsListApi(params = {}){
            return this.processGetRequest(this.showBaseUrl, params);
        },
    } 
}