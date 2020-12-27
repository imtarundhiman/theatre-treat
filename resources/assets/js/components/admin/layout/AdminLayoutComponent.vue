<style  scoped>
/*
 * Off Canvas
 * --------------------------------------------------
 */
@media screen and (max-width: 767px) {
  .row-offcanvas {
    position: relative;
    -webkit-transition: all .25s ease-out;
         -o-transition: all .25s ease-out;
            transition: all .25s ease-out;
  }

  .row-offcanvas-right {
    right: 0;
  }

  .row-offcanvas-left {
    left: 0;
  }

  .row-offcanvas-right
  .sidebar-offcanvas {
    right: -50%; /* 6 columns */
  }

  .row-offcanvas-left
  .sidebar-offcanvas {
    left: -50%; /* 6 columns */
  }

  .row-offcanvas-right.active {
    right: 50%; /* 6 columns */
  }

  .row-offcanvas-left.active {
    left: 50%; /* 6 columns */
  }

  .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 50%; /* 6 columns */
  }
}
</style>

<template>
  <div>
      <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <router-view></router-view>
        </div>
      
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
            <router-link class="list-group-item" tag="a" to="/admin-panel/dashboard">Dashboard</router-link>
            <router-link class="list-group-item" tag="a" to="/admin-panel/theatres">Theatres</router-link>
            <router-link class="list-group-item" tag="a" to="/admin-panel/movies">Movies</router-link>
            <router-link class="list-group-item" tag="a" to="/admin-panel/shows">Shows</router-link>
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->
  </div>
</template>

<script>
import UserDetailsMixins from '@/helpers/modules/user/user.js'
import LogoutComponent from '@/helpers/auth/logout'
export default {
  mixins: [UserDetailsMixins],
  components: {
    'logout-component' : LogoutComponent
  },
  data(){
    return {
      
    }
  },

  created(){
    if(!this.userInfo || !this.userInfo.is_admin){
        this.$notify({
            group: 'auth',
            text: 'You are not authorised to access this page'
        });

        this.$router.push('/');
    }
  }
}
</script>