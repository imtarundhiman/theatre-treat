import Base from '@/helpers/modules/base.js'

export default {
    mixins: [Base],

    data(){
        return {
            slotBaseUrl: "v1/admin/manage-slot",
        }
    },
    
    methods: {
        fetchAllSlot(params = {}){
            return this.processGetRequest(this.slotBaseUrl, params);
        },
    } 
}