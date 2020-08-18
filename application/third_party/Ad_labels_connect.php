<?php
class Ad_labels_connect {
    
    public function view($title, $data, $redirect) {
    return '
        <html>
           <head>
              <title>' . $title . '</title>
           </head>
           <body>
              <!-- Bootstrap CSS -->
              <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
              <!-- Simple Line Icons -->
              <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
              <!-- Custom Styles -->
              <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css?ver=0.0.7.7b2a6" media="all"/>
              <style>
                 @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600);
                 div.center {
                 width: 80%;
                 margin: 15px auto;
                 font-family: "Source Sans Pro", sans-serif;
                 }
                 div.left {
                 width: calc(100% - 50px);
                 background: #FFFFFF;
                 -webkit-box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
                 box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
                 border-radius: 5px;
                 padding: 15px 25px;
                 min-height: 50px;
                 }
                 @import url("https://fonts.googleapis.com/css?family=Nunito+Sans");
                 @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,600");
                 .post-destionation > .row:first-child {
                 border-bottom: 1px solid #e0e6e8;
                 }
                 .clean {
                 padding: 0 !important;
                 margin: 0 !important; }
                 .back-button {
                 margin-right: -4px;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search {
                 height: 60px;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .input-group-prepend {
                 width: 22px;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .input-group-prepend i {
                 line-height: 60px;
                 font-size: 20px;
                 color: #797876;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .composer-search-for-accounts {
                 height: 59px;
                 }
                 .post-destionation > .row:first-child h3 {
                 line-height: 58px;
                 font-size: 18px;
                 padding: 0;
                 margin: 0;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .next-button,
                 .post-destionation > .row:first-child .composer-accounts-search .back-button {
                 border: 1px solid #e3e8ed;
                 -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                 box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                 background: #FFFFFF;
                 outline: none;
                 width: 40px;
                 height: 40px;
                 margin-top: 10px;
                 line-height: 9px;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .next-button.btn-disabled, .post-destionation > .row:first-child .composer-accounts-search .next-button:hover,
                 .post-destionation > .row:first-child .composer-accounts-search .back-button.btn-disabled,
                 .post-destionation > .row:first-child .composer-accounts-search .back-button:hover {
                 color: rgba(65, 106, 166, 0.5);
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .next-button.btn-disabled,
                 .post-destionation > .row:first-child .composer-accounts-search .back-button.btn-disabled {
                 pointer-events: none;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .back-button {
                 border-top-left-radius: 4px;
                 border-bottom-left-radius: 4px;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .next-button {
                 border-top-right-radius: 4px;
                 border-bottom-right-radius: 4px;
                 margin-left: -1px;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .composer-cancel-search-for-accounts {
                 background-color: transparent;
                 border: 0;
                 display: none;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .composer-cancel-search-for-accounts .icon-close {
                 color: #797876;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .composer-cancel-search-for-accounts:hover {
                 cursor: pointer;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .composer-cancel-search-for-accounts:hover .icon-close {
                 opacity: 0.7;
                 }
                 .post-destionation > .row:first-child .composer-accounts-search .form-control {
                 border: 0;
                 }
                 .post-destionation > .row:first-child .composer-manage-members {
                 height: 40px;
                 width: 40px;
                 text-align: center;
                 line-height: 20px;
                 font-size: 20px;
                 background-color: #ffffff;
                 border: 1px solid rgba(65, 106, 166, 0.1);
                 color: #6c757d;
                 float: right;
                 margin-top: 10px;
                 box-shadow: inset 0 -3px 0 0 rgba(65, 106, 166, 0.1) !important;
                 border-radius: 3px;
                 margin-left: 15px;
                 }
                 .post-destionation > .row:first-child .composer-manage-members:hover {
                 color: #333333;
                 border: 1px solid rgba(65, 106, 166, 0.2);
                 box-shadow: inset 0 -3px 0 0 rgba(65, 106, 166, 0.2) !important;
                 }
                 .post-destionation > .row:first-child .composer-manage-members i {
                 margin-right: 0;
                 }
                 .post-destionation .composer-accounts-list {
                 padding: 15px 0;
                 min-height: 665px;
                 }
                 .post-destionation .composer-accounts-list ul {
                 margin: 0;
                 padding: 0;
                 }
                 .post-destionation .composer-accounts-list ul li,
                 .post-destionation .composer-groups-list ul li {
                 background-color: #ffffff;
                 width: 100%;
                 height: 50px;
                 list-style: none;
                 margin-bottom: 15px;
                 border: 1px solid #ffffff;
                 -moz-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                 box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                 }
                 .post-destionation .composer-accounts-list ul li:hover,
                 .post-destionation .composer-groups-list ul li:hover {
                 border: 1px solid #01c0c8;
                 }
                 .post-destionation .composer-accounts-list ul li a,
                 .post-destionation .composer-groups-list ul li a {
                 display: block;
                 width: 100%;
                 padding: 0 15px;
                 height: 50px;
                 line-height: 24px;
                 fill: #848f99;
                 font-weight: 400;
                 font-size: 15px;
                 font-family: "Open Sans", sans-serif;
                 color: #6c757d;
                 }
                 .post-destionation .composer-accounts-list ul li a span,
                 .post-destionation .composer-groups-list ul li a span {
                 font-size: 12px;
                 color: #c0cddc;
                 padding: 0;
                 margin: -2px 0 0;
                 display: block;
                 font-family: "Open Sans", sans-serif, "Arimo";
                 }
                 .post-destionation .composer-accounts-list ul li a span i,
                 .post-destionation .composer-groups-list ul li a span i {
                 font-size: 13px;
                 display: contents;
                 }
                 .post-destionation .composer-accounts-list ul li a i,
                 .post-destionation .composer-groups-list ul li a i {
                 font-size: 26px;
                 float: left;
                 margin-top: 10px;
                 margin-right: 10px;
                 }
                 .post-destionation .composer-accounts-list ul li a i.icon-check,
                 .post-destionation .composer-groups-list ul li a i.icon-check {
                 color: #01c0c8;
                 font-size: 25px;
                 border-radius: 50%;
                 display: none;
                 float: right;
                 margin-top: -35px;
                 transform: scale(0.5);
                 opacity: 0.5;
                 }
                 .post-destionation .composer-accounts-list ul li a:hover,
                 .post-destionation .composer-groups-list ul li a:hover {
                 text-decoration: none;
                 color: #212529;
                 border-bottom: 0;
                 }
                 .post-destionation .composer-accounts-list ul li.account-selected, .post-destionation .composer-accounts-list ul li.group-selected,
                 .post-destionation .composer-groups-list ul li.account-selected,
                 .post-destionation .composer-groups-list ul li.group-selected {
                 border: 1px solid #01c0c8;
                 }
                 .post-destionation .composer-accounts-list ul li.account-selected a i.icon-check, .post-destionation .composer-accounts-list ul li.group-selected a i.icon-check,
                 .post-destionation .composer-groups-list ul li.account-selected a i.icon-check,
                 .post-destionation .composer-groups-list ul li.group-selected a i.icon-check {
                 display: block;
                 -webkit-animation: loadingOpacity 0.3s;
                 animation: loadingOpacity 0.3s;
                 -webkit-animation-fill-mode: forwards;
                 animation-fill-mode: forwards;
                 }
                 .post-destionation .composer-accounts-list ul li.no-accounts-found, .post-destionation .composer-accounts-list ul li.no-groups-found,
                 .post-destionation .composer-groups-list ul li.no-accounts-found,
                 .post-destionation .composer-groups-list ul li.no-groups-found {
                 background-color: transparent;
                 border: 0;
                 line-height: 48px;
                 padding: 0 15px;
                 }
                 .post-destionation .composer-groups-list ul li a {
                 line-height: 45px;
                 }
                 .post-destionation .composer-groups-list ul li a i.icon-check {
                 margin-top: 10px;
                 }
              </style>
              <div class="center">
                 <div class="left">
                    <div class="col-xl-12 post-destionation">
                       <div class="row">
                          <div class="col-8 clean">
                             <h3>Facebook Ad Labels</h3>
                          </div>
                          <div class="col-4 clean text-right composer-accounts-search">
                             <button type="button" class="back-button btn-disabled" data-page="1">
                             <span class="fc-icon fc-icon-left-single-arrow"></span>
                             </button>
                             <button type="button" class="next-button btn-disabled" data-page="2">
                             <span class="fc-icon fc-icon-right-single-arrow"></span>
                             </button>
                          </div>
                       </div>
                       <div class="row">
                          <div class="col-xl-12 composer-accounts-list">
                             <ul>
                                <li>
                                   <a href="#" data-id="5428" data-net="-293500781" data-network="telegram_groups" data-category="false">
                                   <i style="color: #3b5998;" class="icon-social-facebook"></i>
                                   Al optalea<span>
                                   <i class="icon-user"></i> Telegram Groups</span>
                                   <i class="icon-check"></i>
                                   </a>
                                </li>
                             </ul>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>

              <!-- Optional JavaScript -->
              <script src="https://www.rackpoint.co.uk/social/assets/js/jquery.min.js"></script>
              
              <script language="javascript">
              
              </script>

              <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
           </body>
        </html>
    ';
}
}