<style scoped>
/*
 * Globals
 */

body {
  font-family: Georgia, "Times New Roman", Times, serif;
  color: #555;
}

h1, .h1,
h2, .h2,
h3, .h3,
h4, .h4,
h5, .h5,
h6, .h6 {
  margin-top: 0;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-weight: normal;
  color: #333;
}


/*
 * Override Bootstrap's default container.
 */

@media (min-width: 1200px) {
  .container {
    width: 970px;
  }
}


/*
 * Masthead for nav
 */

.website-masthead {
  background-color: #428bca;
  -webkit-box-shadow: inset 0 -2px 5px rgba(0,0,0,.1);
          box-shadow: inset 0 -2px 5px rgba(0,0,0,.1);
}

/* Nav links */

.website-nav {
  float: right !important;
}

.website-nav-item {
  position: relative;
  display: inline-block;
  padding: 10px;
  font-weight: 500;
  color: #cdddeb;
}
.website-nav-item:hover,
.website-nav-item:focus {
  color: #fff;
  text-decoration: none;
}

/* Active state gets a caret at the bottom */
.website-nav .router-link-exact-active {
  color: #fff;
}

/*
 * website name and description
 */

.website-header {
  padding-top: 20px;
  padding-bottom: 20px;
}
.website-title {
  margin-top: 30px;
  margin-bottom: 0;
  font-size: 60px;
  font-weight: normal;
}
.website-description {
  font-size: 20px;
  color: #999;
}


/*
 * Main column and sidebar layout
 */

.website-main {
  font-size: 18px;
  line-height: 1.5;
}

/* Sidebar modules for boxing content */
.sidebar-module {
  padding: 15px;
  margin: 0 -15px 15px;
}
.sidebar-module-inset {
  padding: 15px;
  background-color: #f5f5f5;
  border-radius: 4px;
}
.sidebar-module-inset p:last-child,
.sidebar-module-inset ul:last-child,
.sidebar-module-inset ol:last-child {
  margin-bottom: 0;
}


/* Pagination */
.pager {
  margin-bottom: 60px;
  text-align: left;
}
.pager > li > a {
  width: 140px;
  padding: 10px 20px;
  text-align: center;
  border-radius: 30px;
}


/*
 * website posts
 */

.website-post {
  margin-bottom: 60px;
}
.website-post-title {
  margin-bottom: 5px;
  font-size: 40px;
}
.website-post-meta {
  margin-bottom: 20px;
  color: #999;
}


/*
 * Footer
 */
.website-footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  color: #999;
  text-align: center;
  background-color: #f9f9f9;
  border-top: 1px solid #e5e5e5;
}
.website-footer p:last-child {
  margin-bottom: 0;
}

.website-content {
  margin-top: 10px;
  margin-bottom: 50px;
}

.navbar-brand {
  color: #fff;
}
</style>
<template>
    <div>
        <div class="website-masthead">
          <div class="container">
              <router-link tag="a" to="/" class="navbar-brand" >Theatre Treat</router-link>
              <nav class="website-nav">
                <router-link tag="a" to="/" :class="'website-nav-item'" >Home</router-link>
                <router-link v-if="!this.userInfo" tag="a" to="/login" :class="'website-nav-item'" >Login</router-link>
                <router-link v-if="!this.userInfo" tag="a" to="/register" :class="'website-nav-item'" >Register</router-link>
                <router-link v-if="this.userInfo" tag="a" to="/my-bookings" :class="'website-nav-item'" >My Bookings</router-link>
                <router-link v-if="this.userInfo && this.userInfo.is_admin" tag="a" to="/admin-panel" :class="'website-nav-item'" >Admin Panel</router-link>                
                <a v-if="this.userInfo" :class="'website-nav-item'"  href="javascript:;"><logout-component></logout-component></a>
              </nav>
          </div>
      </div>

      <div class="container website-content">

        <router-view></router-view>

      </div><!-- /.container -->

    <footer class="website-footer">
      <p>Footer of website</p>
    </footer>
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
  }
}
</script>