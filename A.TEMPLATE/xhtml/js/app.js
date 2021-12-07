// Dom7
var $ = Dom7;

// Theme
var theme = 'md';
if (document.location.search.indexOf('theme=') >= 0) {
  theme = document.location.search.split('theme=')[1].split('&')[0];
}

// install plugin first
Framework7.use(debugPlugin);

// Init App
var app = new Framework7({
  id: 'io.framework7.testapp',
  root: '#app',
  theme: theme,
  view : {
	pushState: true
  },
  debugger: false,
  cache: false,
  data: function () {
    return {
      user: {
        firstName: 'DexignZone',
        lastName: 'Team',
      },
    };
  },
  methods: {
    helloWorld: function () {
      app.dialog.alert('Hello World!');
    },
  },
  routes: routes,
  popup: {
    closeOnEscape: true,
  },
  sheet: {
    closeOnEscape: true,
  },
  popover: {
    closeOnEscape: true,
  },
  actions: {
    closeOnEscape: true,
  },
  vi: {
    placementId: 'pltd4o7ibb9rc653x14',
  },
});

setTimeout(function () {
    $('.loader-screen').hide();
}, 2000);

// Option 1. Using one 'page:init' handler for all pages
$(document).on('page:init', function (e) {
  app.panel.close();
}); 

//document.addEventListener("backbutton", onBackKeyDown, false);

var opened = 0;
function exitApp(){
	if (opened > 0) {
		return false;
	} else {
		app.dialog.confirm('Are you sure you want to exit?', 'Exit App', 
		  function () {
			navigator.app.exitApp();
		  },
		  function () {
			opened = 0;  
			return false;
		  }
		);
		opened = 1;
	}
}

		
function onBackKeyDown() {
	// Handle the back button
	if(app.views.main.history.length == 1){
		exitApp();
		e.preventDefault();
	} else {
		app.dialog.close();
		app.views.main.router.back();
		return false;
	}
}

document.addEventListener("backbutton", onBackKeyDown, false);




