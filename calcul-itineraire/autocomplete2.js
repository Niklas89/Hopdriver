         getPlace();
         getPlace_dynamic();

         function getPlace() {
             var defaultBounds = new google.maps.LatLngBounds(
             new google.maps.LatLng(-33.8902, 151.1759),
             new google.maps.LatLng(-33.8474, 151.2631));
             var input = document.getElementById('Destination');
             // var input = document.getElementsByClassName('destination');
             var options = {
                 bounds: defaultBounds,
                 types: ['geocode']
             };
             autocomplete = new google.maps.places.Autocomplete(input, options);
         }

         function getPlace_dynamic() {
             var defaultBounds = new google.maps.LatLngBounds(
             new google.maps.LatLng(-33.8902, 151.1759),
             new google.maps.LatLng(-33.8474, 151.2631));

             var input = document.getElementsByClassName('global-wrap.container.myClass');
             var options = {
                 bounds: defaultBounds,
                 types: ['geocode']
             };

             for (i = 0; i < input.length; i++) {
                 autocomplete = new google.maps.places.Autocomplete(input[i], options);
             }
         }