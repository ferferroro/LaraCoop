function ajax1() {
  // NOTE:  This function must return the value 
  //        from calling the $.ajax() method.
  return $.ajax({
    type:'GET',
    url: "/home/loan_chart_data/",
    dataType: 'json',
    data:{"id":1},
    success:function(data) {
      loans = data.loans;
      quotes = data.quotes;
      loan_by_status = data.loan_by_status;
      contributions = data.contributions;
    }
  });
}

$.when(ajax1()).done(function(a1, a2, a3, a4){
  // the code here will be executed when all four ajax requests resolve.
  // a1, a2, a3 and a4 are lists of length 3 containing the response text,
  // status, and jqXHR object for each of the four ajax calls respectively.


  demo = {
    initPickColor: function() {
      $('.pick-class-label').click(function() {
        var new_class = $(this).attr('new-class');
        var old_class = $('#display-buttons').attr('data-class');
        var display_div = $('#display-buttons');
        if (display_div.length) {
          var display_buttons = display_div.find('.btn');
          display_buttons.removeClass(old_class);
          display_buttons.addClass(new_class);
          display_div.attr('data-class', new_class);
        }
      });
    },

    checkFullPageBackgroundImage: function() {
      $page = $('.full-page');
      image_src = $page.data('image');

      if (image_src !== undefined) {
        image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
        $page.append(image_container);
      }
    },

    initDocChart: function() {
      chartColor = "#FFFFFF";

      ctx = document.getElementById('chartHours').getContext("2d");

      myChart = new Chart(ctx, {
        type: 'line',

        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
          datasets: [{
              borderColor: "#6bd098",
              backgroundColor: "#6bd098",
              pointRadius: 0,
              pointHoverRadius: 0,
              borderWidth: 3,
              data: [300, 310, 316, 322, 330, 326, 333, 345, 338, 354]
            },
            {
              borderColor: "#f17e5d",
              backgroundColor: "#f17e5d",
              pointRadius: 0,
              pointHoverRadius: 0,
              borderWidth: 3,
              data: [320, 340, 365, 360, 370, 385, 390, 384, 408, 420]
            },
            {
              borderColor: "#fcc468",
              backgroundColor: "#fcc468",
              pointRadius: 0,
              pointHoverRadius: 0,
              borderWidth: 3,
              data: [370, 394, 415, 409, 425, 445, 460, 450, 478, 484]
            }
          ]
        },
        options: {
          legend: {
            display: false
          },

          tooltips: {
            enabled: false
          },

          scales: {
            yAxes: [{

              ticks: {
                fontColor: "#9f9f9f",
                beginAtZero: false,
                maxTicksLimit: 5,
                //padding: 20
              },
              gridLines: {
                drawBorder: false,
                zeroLineColor: "#ccc",
                color: 'rgba(255,255,255,0.05)'
              }

            }],

            xAxes: [{
              barPercentage: 1.6,
              gridLines: {
                drawBorder: false,
                color: 'rgba(255,255,255,0.1)',
                zeroLineColor: "transparent",
                display: false,
              },
              ticks: {
                padding: 20,
                fontColor: "#9f9f9f"
              }
            }]
          },
        }
      });

    },

    initChartsPages: function() {
      chartColor = "#FFFFFF";

      ctx = document.getElementById('chartHours').getContext("2d");    
      
      myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [
            {
              borderColor: "#6bd098",
              backgroundColor: "#6bd098",
              pointRadius: 0,
              pointHoverRadius: 0,
              borderWidth: 3,
              data: [ loans[1], 
                      loans[2], 
                      loans[3], 
                      loans[4], 
                      loans[5], 
                      loans[6], 
                      loans[7], 
                      loans[8], 
                      loans[9], 
                      loans[10], 
                      loans[11], 
                      loans[12]
                    ]
            },
            {
              borderColor: "#f17e5d",
              backgroundColor: "#f17e5d",
              pointRadius: 0,
              pointHoverRadius: 0,
              borderWidth: 3,
              data: [ quotes[1], 
                      quotes[2], 
                      quotes[3], 
                      quotes[4], 
                      quotes[5], 
                      quotes[6], 
                      quotes[7], 
                      quotes[8], 
                      quotes[9], 
                      quotes[10], 
                      quotes[11], 
                      quotes[12]
                    ]
            },
            // {
            //   borderColor: "#fcc468",
            //   backgroundColor: "#fcc468",
            //   pointRadius: 0,
            //   pointHoverRadius: 0,
            //   borderWidth: 3,
            //   data: [370, 394, 415, 409, 425, 445, 460, 450, 478, 0, 400]
            // }
          ]
        },
        options: {
          legend: {
            display: false
          },

          tooltips: {
            enabled: false
          },

          scales: {
            yAxes: [{

              ticks: {
                fontColor: "#9f9f9f",
                beginAtZero: false,
                maxTicksLimit: 5,
                //padding: 20
              },
              gridLines: {
                drawBorder: false,
                zeroLineColor: "#ccc",
                color: 'rgba(255,255,255,0.05)'
              }

            }],

            xAxes: [{
              barPercentage: 1.6,
              gridLines: {
                drawBorder: false,
                color: 'rgba(255,255,255,0.1)',
                zeroLineColor: "transparent",
                display: false,
              },
              ticks: {
                padding: 20,
                fontColor: "#9f9f9f"
              }
            }]
          },
        }
      });


      ctx = document.getElementById('chartEmail').getContext("2d");

      myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: [1, 2, 3],
          datasets: [{
            label: "Emails",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: [
              '#e3e3e3',
              '#4acccd',
              '#fcc468',
              '#ef8157'
            ],
            borderWidth: 0,
            data: [
              loan_by_status[1], 
              loan_by_status[2],
              loan_by_status[3], 
              loan_by_status[4], 
              ]
          }]
        },

        options: {

          legend: {
            display: false
          },

          pieceLabel: {
            render: 'percentage',
            fontColor: ['white'],
            precision: 2
          },

          tooltips: {
            enabled: false
          },

          scales: {
            yAxes: [{

              ticks: {
                display: false
              },
              gridLines: {
                drawBorder: false,
                zeroLineColor: "transparent",
                color: 'rgba(255,255,255,0.05)'
              }

            }],

            xAxes: [{
              barPercentage: 1.6,
              gridLines: {
                drawBorder: false,
                color: 'rgba(255,255,255,0.1)',
                zeroLineColor: "transparent"
              },
              ticks: {
                display: false,
              }
            }]
          },
        }
      });

      var speedCanvas = document.getElementById("speedChart");

      var dataFirst = {
        data: [
          contributions[1], 
          contributions[2], 
          contributions[3], 
          contributions[4], 
          contributions[5], 
          contributions[6], 
          contributions[7], 
          contributions[8], 
          contributions[9], 
          contributions[10], 
          contributions[11], 
          contributions[12]
        ],
        fill: false,
        borderColor: '#fbc658',
        backgroundColor: 'transparent',
        pointBorderColor: '#fbc658',
        pointRadius: 4,
        pointHoverRadius: 4,
        pointBorderWidth: 8,
      };

      var speedData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [dataFirst]
      };

      var chartOptions = {
        legend: {
          display: false,
          position: 'top'
        }
      };

      var lineChart = new Chart(speedCanvas, {
        type: 'line',
        hover: false,
        data: speedData,
        options: chartOptions
      });
    },

    initGoogleMaps: function() {
      var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
      var mapOptions = {
        zoom: 13,
        center: myLatlng,
        scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
        styles: [{
          "featureType": "water",
          "stylers": [{
            "saturation": 43
          }, {
            "lightness": -11
          }, {
            "hue": "#0088ff"
          }]
        }, {
          "featureType": "road",
          "elementType": "geometry.fill",
          "stylers": [{
            "hue": "#ff0000"
          }, {
            "saturation": -100
          }, {
            "lightness": 99
          }]
        }, {
          "featureType": "road",
          "elementType": "geometry.stroke",
          "stylers": [{
            "color": "#808080"
          }, {
            "lightness": 54
          }]
        }, {
          "featureType": "landscape.man_made",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#ece2d9"
          }]
        }, {
          "featureType": "poi.park",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#ccdca1"
          }]
        }, {
          "featureType": "road",
          "elementType": "labels.text.fill",
          "stylers": [{
            "color": "#767676"
          }]
        }, {
          "featureType": "road",
          "elementType": "labels.text.stroke",
          "stylers": [{
            "color": "#ffffff"
          }]
        }, {
          "featureType": "poi",
          "stylers": [{
            "visibility": "off"
          }]
        }, {
          "featureType": "landscape.natural",
          "elementType": "geometry.fill",
          "stylers": [{
            "visibility": "on"
          }, {
            "color": "#b8cb93"
          }]
        }, {
          "featureType": "poi.park",
          "stylers": [{
            "visibility": "on"
          }]
        }, {
          "featureType": "poi.sports_complex",
          "stylers": [{
            "visibility": "on"
          }]
        }, {
          "featureType": "poi.medical",
          "stylers": [{
            "visibility": "on"
          }]
        }, {
          "featureType": "poi.business",
          "stylers": [{
            "visibility": "simplified"
          }]
        }]

      }
      var map = new google.maps.Map(document.getElementById("map"), mapOptions);

      var marker = new google.maps.Marker({
        position: myLatlng,
        title: "Hello World!"
      });

      // To add the marker to the map, call setMap();
      marker.setMap(map);
    },

    showNotification: function(from, align) {
      color = 'primary';

      $.notify({
        icon: "nc-icon nc-bell-55",
        message: "Welcome to <b>Paper Dashboard</b> - a beautiful bootstrap dashboard for every web developer."

      }, {
        type: color,
        timer: 8000,
        placement: {
          from: from,
          align: align
        }
      });
    }

  };


});