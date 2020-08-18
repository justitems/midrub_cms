/*
 * Sales javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load sales for graph
     * 
     * @since   0.0.8.1
     */    
    Main.load_sales_for_graph = function () {

        // Prepare data to send
        var data = {
            action: 'load_sales_for_graph'
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/dashboard', 'GET', data, 'load_sales_for_graph');
        
    };

    /*******************************
    ACTIONS
    ********************************/
 
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display sales for graph
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.1
     */
    Main.methods.load_sales_for_graph = function ( status, data ) {

        // Labels array
        var labels = [];

        // Count array
        var count = [];
        
        // Colors array
        var colors = [];

        // Get the graph id
        var ctx = document.getElementById('dashboard-sales-graph');

        // Verify if the success response exists
        if (status === 'success') {
            
            // List sales
            for ( var r = 0; r < data.sales.length; r++ ) {

                // Explode date
                var dat = data.sales[r].fulltime.split('-');

                // Set date
                labels.push(dat[2] + '/' + dat[1]);

                // Set count
                count.push(data.sales[r].number);

                // Set color
                colors.push('#89917E');

            }
            
        } else {

            var date = new Date();

            var day = (date.getDate() < 10)?'0'+date.getDate():date.getDate();

            var month = ((date.getMonth()+1) < 10)?'0' + (date.getMonth()+1):(date.getMonth()+1);

            // Set date
            labels.push(day + '/' + month);

            // Set count
            count.push('0');

            // Set color
            colors.push('#89917E');

        }

		var config = {
			type: 'line',
			data: {
				labels: labels,
				datasets: [{
					label: data.words.transactions,
					backgroundColor: '#89917E',
					borderColor: '#89917E',
					data: count,
					fill: false,
				}]
			},
			options: {
                responsive: true,
                maintainAspectRatio: false,
				title: {
					display: false,
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
                scales: {
                    xAxes: [{
                        categoryPercentage: .35,
                        barPercentage: .7,
                        display: !0,
                        scaleLabel: {
                            display: !1,
                            labelString: "Month"
                        },
                        gridLines: !1,
                        ticks: {
                            display: !0,
                            beginAtZero: !0,
                            fontColor: "#373f50",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: .35,
                        barPercentage: .2,
                        display: !0,
                        scaleLabel: {
                            display: !1,
                            labelString: "Value"
                        },
                        gridLines: {
                            color: "#c3d1e6",
                            drawBorder: !1,
                            offsetGridLines: !1,
                            drawTicks: !1,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#c3d1e6",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            stepSize: 10,
                            display: !0,
                            beginAtZero: !0,
                            fontColor: "#7d879c",
                            fontSize: 13,
                            padding: 10
                        }

                    }]

                }

            }
            
		};

        var ctx = document.getElementById('dashboard-sales-graph').getContext('2d');
        new Chart(ctx, config);

    };
 
    /*******************************
    FORMS
    ********************************/
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');

    // Load sales for graph  
    Main.load_sales_for_graph();
 
});