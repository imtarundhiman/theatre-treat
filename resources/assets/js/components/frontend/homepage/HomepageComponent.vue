<style scoped>
/* CUSTOMIZE THE CAROUSEL
-------------------------------------------------- */
.movie-image {
  width: 100% ;
}

/* Carousel base class */
.carousel {
  height: 350px;
  margin-bottom: 60px;
}
/* Since positioning the image, we need to help out the caption */
.carousel-caption {
  z-index: 10;
}

/* Declare heights because of positioning of img element */
.carousel .item {
  height: 350px;
  background-color: #777;
}
.carousel-inner > .item > img {
  position: absolute;
  top: 0;
  left: 0;
  min-width: 100%;
  height: 350px;
}


/* MARKETING CONTENT
-------------------------------------------------- */

/* Center align the text within the three columns below the carousel */
.marketing .col-lg-4 {
  margin-bottom: 20px;
  text-align: center;
}
.marketing h2 {
  font-weight: normal;
}
.marketing .col-lg-4 p {
  margin-right: 10px;
  margin-left: 10px;
}


/* Featurettes
------------------------- */

.featurette-divider {
  margin: 80px 0; /* Space out the Bootstrap <hr> more */
}

/* Thin out the marketing headings */
.featurette-heading {
  font-weight: 300;
  line-height: 1;
  letter-spacing: -1px;
}


/* RESPONSIVE CSS
-------------------------------------------------- */

@media (min-width: 768px) {
  /* Navbar positioning foo */
  .navbar-wrapper {
    margin-top: 20px;
  }
  .navbar-wrapper .container {
    padding-right: 15px;
    padding-left: 15px;
  }
  .navbar-wrapper .navbar {
    padding-right: 0;
    padding-left: 0;
  }

  /* The navbar becomes detached from the top, so we round the corners */
  .navbar-wrapper .navbar {
    border-radius: 4px;
  }

  /* Bump up size of carousel content */
  .carousel-caption p {
    margin-bottom: 20px;
    font-size: 21px;
    line-height: 1.4;
  }

  .featurette-heading {
    font-size: 50px;
  }
}

@media (min-width: 992px) {
  .featurette-heading {
    margin-top: 120px;
  }
}


/* Main marketing message and sign up button */
.jumbotron {
  text-align: center;
  background-color: transparent;
  padding-top:0;
}

/* Customize the nav-justified links to be fill the entire space of the .navbar */

</style>

<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <!-- Carousel
                ================================================== -->
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                    <img class="first-slide" src="https://mewallpaper.com/thumbnail/celebrities/3990-gal-gadot-wonder-woman-2017-hd-hq-image-free-wallpaper.jpg" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption">
                        <h1>Wonder Women</h1>
                        </div>
                    </div>
                    </div>
                    <div class="item">
                    <img class="second-slide" src="https://i.ytimg.com/vi/v6OGMYUb0wA/maxresdefault.jpg" alt="Second slide">
                    
                    </div>
                    <div class="item">
                    <img class="third-slide" src="https://latestnews.fresherslive.com/images/articles/origin/2020/11/12/panchayat-season-2-release-date-in-india-5fad0cdbaeeba-1605176539.jpg" alt="Third slide">
                    <div class="container">
                        <div class="carousel-caption">
                        <h1>Panchayat</h1>
                        </div>
                    </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                </div><!-- /.carousel -->
            </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <!-- Jumbotron -->
            <div class="jumbotron">
              <h1>Popular Shows</h1>
              <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet.</p>
            </div>
          </div>
        </div>

        <!-- Three columns of text below the carousel -->
      <div class="row" v-infinite-scroll="fetchAllShows" infinite-scroll-disabled="stop" infinite-scroll-distance="10">
        <div v-bind:key="index" v-for="(show,index) in this.shows" class="col-lg-3">
          <img class="img-responsive movie-image" :src="show.movie.image.public_url" alt="Generic placeholder image">
          <h4>{{show.movie.movie_name}}</h4>
          <p>{{ show.movie.description | strLimit(80)  }}</p>
          <p>
            <router-link class="btn btn-default" role="button" tag="a" :to="'/movie/'+(show.movie.slug ? show.movie.slug: show.movie.id)" >View details &raquo;</router-link>
          </p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->
    </div>
</template>

<script>
import _ from 'lodash'
import ShowsMixins from '@/helpers/modules/show/show.js'
import infiniteScroll from 'vue-infinite-scroll'
export default {
  mixins: [ShowsMixins],
  directives: {infiniteScroll},
  data(){
    return {
      shows: [],
      pagination: {
        total: 0,
        to: 0,
        currentPage: 0,
        previousPage: null,
        nextPage: 1,
        lastPage: null,
        from: 1
      },
      stop: false
    }
  },

  mounted(){
    //this.fetchAllShows();
  },

  methods: {
    fetchAllShows : _.debounce(
      function fetchAllShows(){
      this.fetchAllShowsApi({
        page: this.pagination.currentPage + 1,
        per_page: 12
      })
      .then(response => {

        let shows = response.data.data;

        if(!shows.length){
          this.stop = true;
        }

        for (let show of response.data.data) {
          this.shows.push(show);
        }

        this.pagination.total = response.data.total;
        this.pagination.to = response.data.to;
        this.pagination.currentPage = response.data.current_page;
        this.pagination.previousPage = response.data.prev_page_url;
        this.pagination.nextPage = response.data.next_page_url;
        this.pagination.lastPage = response.data.last_page;
        this.pagination.from = response.data.from;
      })
    }, 500)
  },

  filters: {
    strLimit: function(value, size) {
      if (!value) return '';
      value = value.toString();

      if (value.length <= size) {
        return value;
      }
      return value.substr(0, size) + '...';
    }
  }
}
</script>