import Base from '@/helpers/modules/base.js'

export default {
    mixins: [Base],

    data(){
        return {
            theatreBaseUrl: "v1/admin/manage-theatre",
        }
    },
    
    methods: {
        fetchAllTheatre(params = {}){
            return this.processGetRequest(this.theatreBaseUrl, params);
        },
        generateNewTheatreApi(params = {}){
            return this.processPostRequest(this.theatreBaseUrl, params);
        },
        updateTheatreApi(params = {},theatreId = 0){
            params._method = 'put';
            return this.processPostRequest(this.theatreBaseUrl+theatreId, params);
        },
        deleteTheatreApi(theatreId = null, params = {}){
            return this.processDeleteRequest(this.theatreBaseUrl+theatreId,  params);
        },
    } 
}