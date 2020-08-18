<?php
class Social_login_connect {

    public function view($title, $data, $redirect) {
        
        $red = '';
        
        if ( $redirect ) {
            
            $red = '<script language="javascript">'
                    . 'setTimeout(function(){'
                        . 'window.opener.Main.reload_accounts();'
                        . 'window.close();'
                    . '}, 1500);'
                . '</script>';
            
        }

        return '<html>
            <head>
                <title>' . $title . '</title>
            </head>
            <body>
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
                    div.right>h2 {
                        font-size: 18px;
                        margin: 0;
                    }
                    div.right>ol {
                        margin: 10px 0;
                        padding: 0;
                    }
                    div.right>ol>li {
                        margin-left: 15px;
                        line-height: 35px;
                        margin-bottom: 10px;
                    }
                    div.left {
                        float: left;
                    }
                    div.right {
                        float: right;
                    }
                    form {
                        width: 100%;
                    }
                    button {
                        width: 100%;
                        height: 45px;
                        background-color: #6086bf;
                        border-color: #6086bf;
                        color: #FFFFFF;
                        font-size: 14px;
                        display: inline-block;
                        font-weight: 400;
                        text-align: center;
                        white-space: nowrap;
                        vertical-align: middle;
                        -webkit-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        user-select: none;
                        border: 1px solid transparent;
                        padding: .375rem .75rem;
                        font-size: 1rem;
                        line-height: 1.5;
                        border-radius: .25rem;
                        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;  
                    }
                    button:hover {
                        opacity: 0.7;
                        cursor: pointer;
                    }
                    input[type="text"],input[type="password"] {
                        display: block;
                        width: 100%;
                        height: 34px;
                        padding: 6px 12px;
                        font-size: 14px;
                        line-height: 1.428571429;
                        color: #495057;
                        background-color: #fff;
                        background-image: none;
                        border-radius: 4px;
                        background-clip: padding-box;
                        border: 1px solid #d4d5d7;
                        margin-bottom:20px;
                        min-height: 40px;
                    }
                    label {
                        font-size: 15px;
                        margin-bottom: 5px;
                        display: block;
                    }
                    input[type="text"]:focus,input[type="password"]:focus,button:focus{
                        outline: 0;
                    }
                    .alert {
                        padding: 15px;
                        margin-bottom: 20px;
                        border: 0;
                        border-radius: 5px;
                        color: #FFFFFF;
                    }
                    .alert-success {
                        background-color: #00a28a;
                    }
                    .alert-error {
                        background-color: #ea6759;
                    }
                </style>
                ' . $red . '
                <div class="center">
                    <div class="left">
                        '. $data . '
                    </div>
                </div>
            </body>
        </html>';
        
    }
    
}