<style scoped>
body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
<template>
    <div>
        <form class="form-signin" @submit.prevent="register" role="form">
            <h2 class="form-signin-heading">Please sign up</h2>
            <label for="inputEmail" class="sr-only">Name</label>
            <input type="text" id="inputEmail" name="name" v-model="name" class="form-control" placeholder="Full Name">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="text" id="inputEmail" name="email" v-model="email" class="form-control" placeholder="Email address">
            <label for="inputEmail" class="sr-only">Username</label>
            <input type="text" id="inputEmail" name="username" v-model="username" class="form-control" placeholder="Username">
            <label for="inputPassword" class="sr-only">Mobile</label>
            <input type="text" id="inputEmail" name="mobile" v-model="mobile" class="form-control" placeholder="Mobile">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" v-model="password" id="inputPassword" class="form-control" placeholder="Password">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
</template>

<script>

import _ from 'lodash'
export default {
  data () {
    return {
      email: '',
      password: '',
      name: '',
      username: '',
      mobile: ''
    }
  },

  methods: {    
    register: _.debounce(
        function(){
            $('.errors').empty();
            let email = this.email 
            let password = this.password
            let name = this.name
            let username = this.username
            let mobile = this.mobile
            this.$store.dispatch('register', { email, password, name, username,mobile  })
            .then(resp => {
              this.$router.push('/login');
            })
            .catch(error => {
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
        }, 500 )
  }
}
</script>