/*
 * Members javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load members for graph
     * 
     * @since   0.0.8.5
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
 
    /*
    * Load default content
    *
    * @since   0.0.8.5
    */
    $(function () {

        // Load members for graph  
        Main.load_members_for_graph();

    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display members for graph
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.5
     */
    Main.methods.display_members_for_graph = function ( status, data ) {

        // Values array
        var values = [];

        // Verify if the success response exists
        if (status === 'success') {
            
            // List users
            for ( var r = 0; r < data.users.length; r++ ) {

                // Set values
                values.push([(data.users[r].time * 1000), data.users[r].number]);

            }

            // Prepare the options for chart
            var options = {
                chart: {
                    type: "line",
                    height: 300,
                    foreColor: "#999",
                    stacked: true,
                    dropShadow: {
                        enabled: true,
                        enabledSeries: [0],
                        top: -2,
                        left: 2,
                        blur: 5,
                        opacity: 0.06,
                    },
                    toolbar: {
                        show: false,
                    }
                },
                colors: ["#2E92FA"],
                stroke: {
                    curve: "smooth",
                    width: 2,
                },
                dataLabels: {
                    enabled: false,
                },
                series: [
                    {
                        name: words.joined_members,
                        data: values
                    }
                ],
                markers: {
                    size: 0,
                    strokeColor: "#fff",
                    strokeWidth: 3,
                    strokeOpacity: 1,
                    fillOpacity: 1,
                    hover: {
                        size: 6,
                    }
                },
                xaxis: {
                    labels: {
                      format: 'dd/MM',
                    }
                },
                yaxis: {
                    tickAmount: 1,
                    labels: {
                        offsetX: 14,
                        offsetY: -5,
                    },
                    tooltip: {
                        enabled: true,
                    },
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        }
                    }
                },
                grid: {
                    show: true,
                    borderColor: "#f7f9fc",
                    strokeDashArray: 0,
                    position: "back",
                    padding: {
                        left: -5,
                        right: 5,
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM yyyy",
                    }
                },
                legend: {
                    position: "top",
                    horizontalAlign: "left",
                },
                fill: {
                    type: "solid",
                    fillOpacity: 0.7,
                }
            };
            
            // Set chart's options
            var chart = new ApexCharts(document.querySelector("#dashboard-widget-chart"), options);
            
            // Render the options
            chart.render();
            
        } else {

            // Prepare the missing members message
            let no_members = '<ul class="dashboard-widget-tickets-list theme-card-box-list">'
                + '<li class="default-card-box-no-items-found">'
                    + words.no_joined_members
                + '</li>'
            + '</ul>';

            // Display the missing members message
            $('.dashboard-page .dashboard-widgets-list > .dashboard-widget[data-widget="joined_members"] .card-body').html(no_members);

        }

    };
 
});