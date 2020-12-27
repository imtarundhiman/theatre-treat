import Base from '@/helpers/modules/base.js'

export default {
    mixins: [Base],

    data(){
        return {
            
        }
    },
    
    methods: {
      
        bookTicketApi(params = {}){
            return this.processPostRequest("v1/book-ticket", params);
        },

        showMyBookingsApi(params = {}){
            return this.processGetRequest("v1/show-my-bookings", params);
        }
    } 
}