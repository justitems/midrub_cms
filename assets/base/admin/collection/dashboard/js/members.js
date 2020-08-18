/*
 * Members javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load members for graph
     * 
     * @since   0.0.8.1
     */    
    Main.load_members_for_graph = function () {

        // Prepare data to send
        var data = {
            action: 'load_members_for_graph'
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/dashboard', 'GET', data, 'display_members_for_graph');
        
    };

    /*******************************
    ACTIONS
    ********************************/
 
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display members for graph
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.1
     */
    Main.methods.display_members_for_graph = function ( status, data ) {

        // Labels array
        var labels = [];

        // Count array
        var count = [];
        
        // Colors array
        var colors = [];

        // Get the graph id
        var ctx = document.getElementById('dashboard-members-graph');

        // Verify if the success response exists
        if (status === 'success') {
            
            // List users
            for ( var r = 0; r < data.users.length; r++ ) {

                // Explode date
                var dat = data.users[r].datetime.split('-');

                // Set date
                labels.push(dat[2] + '/' + dat[1]);

                // Set count
                count.push(data.users[r].number);

                // Set color
                colors.push('rgba(75, 192, 192, 0.2)');

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
            colors.push('rgba(75, 192, 192, 0.2)');

        }
        
        // Generate and display Graph
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: data.words.members,
                    data: count,
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1,
                    pointRadius: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
                            max: 70,
                            stepSize: 10,
                            display: !0,
                            beginAtZero: !0,
                            fontColor: "#7d879c",
                            fontSize: 13,
                            padding: 10
                        }

                    }]

                },

                title: {
                    display: !1
                },
                hover: {
                    mode: "index"
                },
                tooltips: {
                    enabled: !0,
                    intersect: !1,
                    mode: "nearest",
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10,
                    caretPadding: 0,
                    displayColors: !1,
                    backgroundColor: "#95aac9",
                    titleFontColor: "#ffffff",
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 5,
                        bottom: 5
                    }

                }

            }

        });

    };
 
    /*******************************
    FORMS
    ********************************/
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');

    // Load members for graph  
    Main.load_members_for_graph();
 
});