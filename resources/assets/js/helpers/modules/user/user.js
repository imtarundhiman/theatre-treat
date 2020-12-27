import Base from '@/helpers/modules/base.js'

export default {
    mixins: [Base],
    computed: {
        isAdmin() {
            return this.$store.getters.user &&  this.$store.getters.user.is_admin? true : false;
        },
        userInfo(){
            return this.$store.getters.user ? this.$store.getters.user : null;
        }
    }
}