/*
 * Default Posts Lists JavaScript file
*/

(function( $ ) {

    /*******************************
      POSTS LISTS WITH CALENDAR
    ********************************/
 
    /*
     * Show the week calendar with the navigation
     * 
     * @param object options
     */  
    $.fn.default_posts_lists = function(options) {

        // Save this
        let $this = this;

        // Verify if list is already loaded
        if ( $this.find('.default-posts-list-posts').length < 1 ) {

            // Verify if the required parameters exists
            if ( !$this.attr('data-month') || !$this.attr('data-date') || !$this.attr('data-year') || !$this.attr('data-first-day') ) {
                return
            }

            // Create calendar container
            let calendar = '<div class="card-header d-flex justify-content-between">'
                + '<h3></h3>'
                + '<div class="btn-group" role="group" aria-label="Navigation Buttons">'
                    + '<button type="button" class="btn btn-secondary default-posts-list-previous-week-btn">'
                        + words.icon_arrow_left_circle
                    + '</button>'
                    + '<button type="button" class="btn btn-secondary default-posts-list-next-week-btn">'
                        + words.icon_arrow_right_circle
                    + '</button>'
                + '</div>'
            + '</div>'
            + '<div class="card-body">'
                + '<div class="default-posts-list-days">'
                + '</div>'
            + '</div>'
            + '<div class="card-posts">'
                + '<div class="default-posts-list-posts"></div>'
            + '</div>'
            + '<div class="card-navigation">'
                + '<button type="button" class="btn btn-success theme-button-3 default-posts-list-navigation-new-btn default-posts-list-navigation-disabled-btn">'
                    + words.icon_arrow_left_line
                + '</button>'
                + '<button type="button" class="btn btn-success theme-button-3 default-posts-list-navigation-old-btn default-posts-list-navigation-disabled-btn">'
                    + words.icon_arrow_right_line
                + '</button>'
            + '</div>';

            // Display the calendar container
            $this.html(calendar);

            // Hide the navigation
            $this.find('.card-navigation').hide(); 

            // Get date
            let date = $this.attr('data-date');

            // Get month
            let month = $this.attr('data-month');

            // Get year
            let year = $this.attr('data-year');

            // Format
            let current_date_format = new Date(year + '-' + month + '-' + date);

            // Set This Week
            var this_week;

            // Verify if first day of the week is monday
            if ( parseInt($this.attr('data-first-day')) === 1 ) {

                // Prepare day of the week
                let the_week_date = (current_date_format.getDay() === 0)?6:(current_date_format.getDay() - 1);

                // Set This Week
                this_week = new Date(current_date_format.setDate(current_date_format.getDate() - the_week_date));

            } else {

                // Set This Week
                this_week = new Date(current_date_format.setDate(current_date_format.getDate() - (current_date_format.getDay() - 1)))

            }

            // Prepare the new time
            let new_time = this_week.toISOString().split('T')[0].split('-');

            // Set date
            $this.attr('data-date', new_time[2]);

            // Set month
            $this.attr('data-month', new_time[1]);

            // Set year
            $this.attr('data-year', new_time[0]);

            // Display the calendar data
            $this.default_posts_lists_show_calendar_data(this_week);

            // Detect date click
            $this.on('change', '.default-posts-list-days input[type="radio"]', function () {

                // Display the date change
                $this.default_posts_lists_change_date($(this));

            });

            // Detect previous week button click
            $this.on('click', '.default-posts-list-previous-week-btn', function (e) {
                e.preventDefault();

                // Display the previous week in the calendar
                $this.default_posts_lists_show_previous_week_in_calendar();

            });

            // Detect next week button click
            $this.on('click', '.default-posts-list-next-week-btn', function (e) {
                e.preventDefault();

                // Display the next week in the calendar
                $this.default_posts_lists_show_next_week_in_calendar();

            });

            // Detect navigation button click
            $this.on('click', '.default-posts-list-navigation-old-btn, .default-posts-list-navigation-new-btn', function (e) {
                e.preventDefault();

                // Verify if page change exists
                if ( $this.pageChange ) {

                    // Run function
                    $this.pageChange($(this).attr('data-page'));

                }

            });

            // Verify dateChange exists
            if ( typeof options.dateChange === 'function' ) {

                // Register the hook
                $this.dateChange = options.dateChange;

            }

            // Verify pageChange exists
            if ( typeof options.pageChange === 'function' ) {

                // Register the hook
                $this.pageChange = options.pageChange;

            }

        } else {

            // Set a short pause
            setTimeout(function () {

                // Verify setPosts exists
                if ( (typeof options.setPosts === 'object') && (typeof options.setTotalPosts === 'number') && (typeof options.setPage === 'number') ) {

                    // Display the posts
                    $this.default_posts_lists_show_the_posts({posts: options.setPosts, total: options.setTotalPosts, page: options.setPage});

                } else {

                    // Display the no posts message
                    $this.default_posts_lists_show_the_no_posts_message(options.setNoPostsMessage);                    

                }

            }, 400);

        }

    };

    /*
     * Display the calendar data
     * 
     * @param object this_week
     */
    $.fn.default_posts_lists_show_calendar_data = function (this_week) {

        // Display Month And Year
        this.find('.card-header > h3').html(this.default_posts_lists_the_month_text((this_week.getMonth() + 1), this_week.getFullYear()));

        // Set Monday
        let monday = this_week.getDate();

        // Set Tuesday
        let tuesday = new Date(this_week.getTime() + 1 * 24 * 60 * 60 * 1000);

        // Set Wednesday
        let wednesday = new Date(this_week.getTime() + 2 * 24 * 60 * 60 * 1000);

        // Set Thursday
        let thursday = new Date(this_week.getTime() + 3 * 24 * 60 * 60 * 1000);

        // Set Friday
        let friday = new Date(this_week.getTime() + 4 * 24 * 60 * 60 * 1000);

        // Set Saturday
        let saturday = new Date(this_week.getTime() + 5 * 24 * 60 * 60 * 1000);

        // Set Sunday
        let sunday = new Date(this_week.getTime() + 6 * 24 * 60 * 60 * 1000);

        // Calendar container
        var calendar = '';

        // Verify if first day of the week is monday
        if ( parseInt(this.attr('data-first-day')) === 1 ) {

            // Days object
            let days = {
                '1': (this.attr('data-datestamp') === this_week.toISOString().split('T')[0])?' checked':'',
                '2': (this.attr('data-datestamp') === tuesday.toISOString().split('T')[0])?' checked':'',
                '3': (this.attr('data-datestamp') === wednesday.toISOString().split('T')[0])?' checked':'',
                '4': (this.attr('data-datestamp') === thursday.toISOString().split('T')[0])?' checked':'',
                '5': (this.attr('data-datestamp') === friday.toISOString().split('T')[0])?' checked':'',
                '6': (this.attr('data-datestamp') === saturday.toISOString().split('T')[0])?' checked':'',
                '7': (this.attr('data-datestamp') === sunday.toISOString().split('T')[0])?' checked':'',
            };

            // Create the calendar
            calendar = '<div class="default-posts-list-navigation">'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-1" class="default-posts-list-tab" id="default-posts-list-1" data-datestamp="' + this_week.toISOString().split('T')[0] + '"' + days[1] + ' />'
                + '<label for="default-posts-list-1">'
                    + words.mon
                    + '<span>'
                        + monday
                    + '</span>'
                + '</label>'                         
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-2" class="default-posts-list-tab" id="default-posts-list-2" data-datestamp="' + tuesday.toISOString().split('T')[0] + '"' + days[2] + ' />'
                + '<label for="default-posts-list-2">'
                    + words.tue
                    + '<span>'
                        + tuesday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-3" class="default-posts-list-tab" id="default-posts-list-3" data-datestamp="' + wednesday.toISOString().split('T')[0] + '"' + days[3] + ' />'
                + '<label for="default-posts-list-3">'
                    + words.wed
                    + '<span>'
                        + wednesday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-4" class="default-posts-list-tab" id="default-posts-list-4" data-datestamp="' + thursday.toISOString().split('T')[0] + '"' + days[4] + ' />'
                + '<label for="default-posts-list-4">'
                    + words.thu
                    + '<span>'
                        + thursday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-5" class="default-posts-list-tab" id="default-posts-list-5" data-datestamp="' + friday.toISOString().split('T')[0] + '"' + days[5] + ' />'
                + '<label for="default-posts-list-5">'
                    + words.fri
                    + '<span>'
                        + friday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-6" class="default-posts-list-tab" id="default-posts-list-6" data-datestamp="' + saturday.toISOString().split('T')[0] + '"' + days[6] + ' />'
                + '<label for="default-posts-list-6">'
                    + words.sat
                    + '<span>'
                        + saturday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-7" class="default-posts-list-tab" id="default-posts-list-7" data-datestamp="' + sunday.toISOString().split('T')[0] + '"' + days[7] + ' />'
                + '<label for="default-posts-list-7">'
                    + words.sun
                    + '<span>'
                        + sunday.getDate()
                    + '</span>'
                + '</label>'                  
                + '<div class="default-posts-list-navigation-active"></div>'
            + '</div>';

        } else {

            // Days object
            let days = {
                '1': (this.attr('data-datestamp') === this_week.toISOString().split('T')[0])?' checked':'',
                '2': (this.attr('data-datestamp') === tuesday.toISOString().split('T')[0])?' checked':'',
                '3': (this.attr('data-datestamp') === wednesday.toISOString().split('T')[0])?' checked':'',
                '4': (this.attr('data-datestamp') === thursday.toISOString().split('T')[0])?' checked':'',
                '5': (this.attr('data-datestamp') === friday.toISOString().split('T')[0])?' checked':'',
                '6': (this.attr('data-datestamp') === saturday.toISOString().split('T')[0])?' checked':'',
                '7': (this.attr('data-datestamp') === new Date(this_week.getTime() - 1 * 24 * 60 * 60 * 1000).toISOString().split('T')[0])?' checked':'',
            };

            // Calculate the sunday
            let sunday_date = new Date(this_week.getTime() - 1 * 24 * 60 * 60 * 1000);

            // Create the calendar
            calendar = '<div class="default-posts-list-navigation">'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-1" class="default-posts-list-tab" id="default-posts-list-1" data-datestamp="' + sunday_date.toISOString().split('T')[0] + '"' + days[7] + ' />'
                + '<label for="default-posts-list-1">'
                    + words.sun
                    + '<span>'
                        + sunday_date.getDate()
                    + '</span>'
                + '</label>'                         
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-2" class="default-posts-list-tab" id="default-posts-list-2" data-datestamp="' + this_week.toISOString().split('T')[0] + '"' + days[1] + ' />'
                + '<label for="default-posts-list-2">'
                    + words.mon
                    + '<span>'
                        + monday
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-3" class="default-posts-list-tab" id="default-posts-list-3" data-datestamp="' + tuesday.toISOString().split('T')[0] + '"' + days[2] + ' />'
                + '<label for="default-posts-list-3">'
                    + words.tue
                    + '<span>'
                        + tuesday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-4" class="default-posts-list-tab" id="default-posts-list-4" data-datestamp="' + wednesday.toISOString().split('T')[0] + '"' + days[3] + ' />'
                + '<label for="default-posts-list-4">'
                    + words.wed
                    + '<span>'
                        + wednesday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-5" class="default-posts-list-tab" id="default-posts-list-5" data-datestamp="' + thursday.toISOString().split('T')[0] + '"' + days[4] + ' />'
                + '<label for="default-posts-list-5">'
                    + words.thu
                    + '<span>'
                        + thursday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-6" class="default-posts-list-tab" id="default-posts-list-6" data-datestamp="' + friday.toISOString().split('T')[0] + '"' + days[5] + ' />'
                + '<label for="default-posts-list-6">'
                    + words.fri
                    + '<span>'
                        + friday.getDate()
                    + '</span>'
                + '</label>'
                + '<input name="default-posts-list-tab" type="radio" value="#default-posts-list-tab-7" class="default-posts-list-tab" id="default-posts-list-7" data-datestamp="' + saturday.toISOString().split('T')[0] + '"' + days[6] + ' />'
                + '<label for="default-posts-list-7">'
                    + words.sat
                    + '<span>'
                        + saturday.getDate()
                    + '</span>'
                + '</label>'                  
                + '<div class="default-posts-list-navigation-active"></div>'
            + '</div>';

        }

        // Display the calendar days
        this.find('.default-posts-list-days').html(calendar);

    };

    /*
     * Display the date change
     *
     * @param object $this
     * 
     */
    $.fn.default_posts_lists_change_date = function ($this) {

        // Enable the navigation
        this.removeClass('default-posts-list-no-active');

        // Set selected date
        this.attr('data-datestamp', $this.attr('data-datestamp'));

        // Verify if date change exists
        if ( this.dateChange ) {

            // Run function
            this.dateChange();

        }

    };

    /*
     * Display the previous week in the calendar
     */
    $.fn.default_posts_lists_show_previous_week_in_calendar = function () {

        // Get date
        let date = this.attr('data-date');

        // Get month
        let month = this.attr('data-month');
        
        // Get year
        let year = this.attr('data-year');

        // Format
        let current_date_format = new Date(year + '-' + month + '-' + date);

        // Set Previous Week
        let previous_week = new Date(current_date_format.getTime() - 7 * 24 * 60 * 60 * 1000);

        // Prepare the new time
        let new_time = previous_week.toISOString().split('T')[0].split('-');

        // Set date
        this.attr('data-date', new_time[2]);

        // Set month
        this.attr('data-month', new_time[1]);
        
        // Set year
        this.attr('data-year', new_time[0]);

        // Disable the navigation
        this.addClass('default-posts-list-no-active');

        // Display the calendar data
        this.default_posts_lists_show_calendar_data(previous_week);

    };

    /*
     * Display the next week in the calendar
     */
    $.fn.default_posts_lists_show_next_week_in_calendar = function () {
        
        // Get date
        let date = this.attr('data-date');

        // Get month
        let month = this.attr('data-month');
        
        // Get year
        let year = this.attr('data-year');

        // Format
        let current_date_format = new Date(year + '-' + month + '-' + date);

        // Set Next Week
        let next_week = new Date(current_date_format.getTime() + 7 * 24 * 60 * 60 * 1000);

        // Prepare the new time
        let new_time = next_week.toISOString().split('T')[0].split('-');

        // Set date
        this.attr('data-date', new_time[2]);

        // Set month
        this.attr('data-month', new_time[1]);
        
        // Set year
        this.attr('data-year', new_time[0]);
        
        // Disable the navigation
        this.addClass('default-posts-list-no-active');

        // Display the calendar data
        this.default_posts_lists_show_calendar_data(next_week);

    };

    /*
     * Display the posts
     *
     * @param object obj
     * 
     */
    $.fn.default_posts_lists_show_the_posts = function (obj) {

        // Verify if posts exists
        if ( obj.posts.length > 0 ) {

            // The posts list container
            var posts_list = '';

            // List the posts
            for ( var p = 0; p < obj.posts.length; p++ ) {

                // Verify if post id and post created time exists
                if ( (typeof obj.posts[p].post_id !== 'number') || (typeof obj.posts[p].post_created !== 'string') || (typeof obj.posts[p].post_url !== 'string') ) {
                    continue;
                }

                // The text container
                var text = '';

                // Verify if the post has text
                if ( typeof obj.posts[p].post_text === 'string' ) {

                    // Set text
                    text = '<div class="row">'
                        + '<div class="col-12">'
                            + '<h5 class="mt-0">'
                                + obj.posts[p].post_text
                            + '</h5>'
                        + '</div>'
                    + '</div>';

                }

                // The url container
                var the_url = '';

                // Verify if the post has link
                if ( typeof obj.posts[p].post_link === 'string' ) {

                    // Add url to the container
                    the_url = '<div class="row">'
                        + '<div class="col-12">'
                            + '<div class="default-posts-list-posts-post-link">'
                                + words.icon_bi_link_default
                                + '<span>'
                                    + obj.posts[p].post_link
                                + '</span>'
                            + '</div>'
                        + '</div>'
                    + '</div>';

                }

                // Images container
                var images = '';

                // Verify if the post has images
                if ( typeof obj.posts[p].post_images === 'object' ) {

                    // Verify if the post has images
                    if ( obj.posts[p].post_images.length > 0 ) {

                        // List the images
                        for ( var i = 0; i < obj.posts[p].post_images.length; i++ ) {

                            // Add image to the container
                            images += '<img src="' + obj.posts[p].post_images[i] + '" alt="Media File" onerror="this.src=\'' + $('meta[name=url]').attr('content') + 'assets/img/no-image.png\';">';

                        }

                        // Set start of the list
                        images = '<div class="row">'
                            + '<div class="col-12">'
                                + '<div class="default-posts-list-posts-post-images">'
                                    + images
                                + '</div>'
                            + '</div>'
                        + '</div>';

                    } 

                }
                
                // Video container
                var video = '';

                // Verify if the post has video
                if ( typeof obj.posts[p].post_video === 'string' ) {

                    // Add video to the container
                    video = '<div class="row">'
                        + '<div class="col-12">'
                            + '<div class="default-posts-list-posts-post-video">'
                                + '<iframe src="' + obj.posts[p].post_video + '"></iframe>'
                            + '</div>'
                        + '</div>'
                    + '</div>';

                }

                // The accounts container
                var accounts = '';

                // Verify if accounts exists
                if ( typeof obj.posts[p].post_accounts === 'object' ) {

                    // Start accounts list
                    accounts = '<ul class="default-posts-list-posts-post-accounts">';

                    // Unique networks
                    var unique_networks = [];

                    // List the accounts
                    for ( var a = 0; a < obj.posts[p].post_accounts.length; a++ ) {

                        // Verify if the required parameters exists
                        if ( (typeof obj.posts[p].post_accounts[a].network_icon !== 'string') || (typeof obj.posts[p].post_accounts[a].network_slug !== 'string') ) {
                            continue;
                        }

                        // Create a div
                        let div = document.createElement('div');

                        // Set the network icon
                        div.innerHTML = obj.posts[p].post_accounts[a].network_icon;

                        // Get the html object
                        let icon = div.firstChild;

                        // Add account to the container
                        accounts += '<li>'
                            + icon.outerHTML.replace('default-accounts-directory-accounts-area-select-account-icon', 'default-posts-list-posts-post-account-icon')
                        + '</li>';

                        // Verify if unique_networks doesn't contain this network
                        if ( unique_networks.indexOf(obj.posts[p].post_accounts[a].network_slug) < 0 ) {

                            // Set unique network name
                            unique_networks.push(obj.posts[p].post_accounts[a].network_slug);

                        }
                        
                        // Verify if unique_networks contains two networks
                        if ( unique_networks.length > 1 ) {
                            break;
                        }

                    }

                    // Verify if total accounts is greater than unique networks
                    if ( obj.posts[p].post_accounts.length > unique_networks.length ) {

                        // Set left accounts
                        accounts += '<li>'
                            + '<i class="default-posts-list-posts-post-account-more-icon">'
                                + '+' + (obj.posts[p].post_accounts.length - unique_networks.length)
                            + '</i>'
                        + '</li>';

                    }

                    // End the accounts list
                    accounts += '</ul>';

                }

                // Add the post to the container
                posts_list += '<div class="default-posts-list-posts-post">'
                    + '<div class="media">'
                        + '<span class="default-posts-list-posts-post-time">'
                            + obj.posts[p].post_created
                        + '</span>'
                        + '<div class="media-body">'
                            + text
                            + the_url
                            + images
                            + video
                            + '<div class="row">'
                                + '<div class="col-8">'
                                    + accounts
                                + '</div>'
                                + '<div class="col-4 text-right">'
                                    + '<a href="' + obj.posts[p].post_url + '" class="default-posts-list-posts-post-chart-btn">'
                                        + words.icon_chart
                                    + '</a>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            // Display the posts
            this.find('.card-posts .default-posts-list-posts').html(posts_list);

            // Set decrease page for new button
            this.find('.default-posts-list-navigation-new-btn').attr('data-page', (obj.page - 1));

            // Set decrease page for old button
            this.find('.default-posts-list-navigation-old-btn').attr('data-page', (obj.page + 1)); 

            // Verify if the new button should be disabled
            if ( (obj.page - 1) < 1 ) {

                // Add default-posts-list-navigation-disabled-btn class
                this.find('.default-posts-list-navigation-new-btn').addClass('default-posts-list-navigation-disabled-btn');

            } else {

                // Remove default-posts-list-navigation-disabled-btn class
                this.find('.default-posts-list-navigation-new-btn').removeClass('default-posts-list-navigation-disabled-btn');

            }

            // Verify if the old button should be disabled
            if ( (obj.page * 10) < obj.total ) {

                // Remove default-posts-list-navigation-disabled-btn class
                this.find('.default-posts-list-navigation-old-btn').removeClass('default-posts-list-navigation-disabled-btn');

            } else {

                // Add default-posts-list-navigation-disabled-btn class
                this.find('.default-posts-list-navigation-old-btn').addClass('default-posts-list-navigation-disabled-btn');

            }  

            // Show the navigation
            this.find('.card-navigation').show(); 

        }
        
    };

    /*
     * Display the no posts message
     *
     * @param string message
     * 
     */
    $.fn.default_posts_lists_show_the_no_posts_message = function (message) {

        // Check if the message is string
        if ( typeof message === 'string' ) {

            // Hide the navigation
            this.find('.card-navigation').hide(); 

            // Prepare the posts found message
            let no_posts_message = '<div class="default-posts-list-posts-no-posts-found">'
                + message
            + '</div>';

            // Display the no posts found message
            this.find('.default-posts-list-posts').html(no_posts_message);

        }
        
    };

    /*******************************
      GENERAL FUNCTIONS
    ********************************/

    /*
     * Get the month text
     *
     * @param integer month contains the index
     * @param integer year contains the year
     * 
     * @return string
     */  
    $.fn.default_posts_lists_the_month_text = function(month, year) {
 
        // Set months
        var months = [
            '',
            Main.translation.theme_january,
            Main.translation.theme_february,
            Main.translation.theme_march,
            Main.translation.theme_april,
            Main.translation.theme_may,
            Main.translation.theme_june,
            Main.translation.theme_july,
            Main.translation.theme_august,
            Main.translation.theme_september,
            Main.translation.theme_october,
            Main.translation.theme_november,
            Main.translation.theme_december
        ];

        // Return month and year
        return months[parseInt(month)] + ' ' + year;
        
    };

}( jQuery ));