import _ from 'lodash'
import UserDetailsMixins from '@/helpers/modules/user/user.js'
export default {
    mixins: [UserDetailsMixins],
    template: `<span :class="className" @click="logout">
                    Logout
                </span>`,
    
    data(){
        return {
        }
    },
    props: {
        className: ""
    },
    methods: {
        logout: _.debounce(
            function(){
                this.$store.dispatch('logout')
                .then(resp => {
                    this.$notify({
                        group: 'auth',
                        text: resp.data.message
                    });
                    axios.get('v1/auth/check')
                })
                .catch(err => console.log(err))
            }, 
        500 ),
    }
}