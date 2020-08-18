<?php
class Social_login{
    
    /**
     * Class variables
     */
    protected $CI;
    
    public function key_rep($key) {
        if($key) {
            return strtolower(str_replace([' '],['_'],$key));
        } else {
            return false;
        }
        
    }
    public function content($a,$b,$c,$d,$e,$f,$h=NULL) {

        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        if($b == 'Password') {
            $p = '<div class="control-group">
                    <label class="control-label" for="' . $this->key_rep($b) . '">' . $b . ':</label>
                    <div class="controls">
                        <input required="" id="password" name="password" class="form-control" type="password" placeholder="********">
                    </div>
                </div>';
        } else {
            $p = '<div class="control-group">
                    <label class="control-label" for="' . $this->key_rep($b) . '">' . $b . ':</label>
                    <div class="controls">
                        <input required="" id="' . $this->key_rep($b) . '" name="' . $this->key_rep($b) . '" type="text" class="form-control" placeholder="' . $b . '">
                    </div>
                </div>';
        }
        $proxy_support = '';
        if ( $e === 'instagram' || $e === 'instagram_stories' ) {
            $p .= '<div class="control-group">
                    <label class="control-label" for="user">' . $this->CI->lang->line('proxy') . ':</label>
                    <div class="controls">
                        <input id="proxy" name="proxy" type="text" class="form-control" placeholder="' . $this->CI->lang->line('proxy_format') . '">
                    </div>
                </div>';
            $proxy_support = '<div class="control-group"><p style="font-size: 14px;color: #777777;">' . $this->CI->lang->line('proxy_support') . '</p></div>';
        }   
        if (!$b) {
            $p = '';
        }
        $t = '<div class="control-group">
                <label class="control-label" for="user">' . $a . ':</label>
                <div class="controls">
                    <input required="" id="' . $this->key_rep($a) . '" name="' . $this->key_rep($a) . '" type="text" class="form-control" placeholder="' . $a . '">
                </div>
            </div>' . $p;
        if($a === 'Access Token') {
            $t = '<div class="control-group">
                    <label class="control-label" for="user">' . $a . ':</label>
                    <div class="controls">
                        <input required="" id="' . $this->key_rep($a) . '" name="' . $this->key_rep($a) . '" type="text" class="form-control" placeholder="' . $a . '">
                    </div>
                </div>';
        }     
        $url = 'user/connect/' . strtolower($e);
        if($h) {
            $url = $h;
        }
        return '<html>
            <head>
                <title>' . get_instance()->lang->line('social_connector') . '</title>
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
                        min-height: 150px;
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
                </style>
                <div class="center">
                    <div class="left">
                        '.form_open($url).'
                            ' . $t . '
                            <div class="control-group">
                                <label class="control-label" for="signin"></label>
                                <div class="controls">
                                    <button id="signin" type="submit" name="signin" class="btn btn-success">' . $c . '</button>
                                </div>
                                ' . $proxy_support . '
                            </div>
                        '.form_close().'
                    </div>
                </div>
            </body>
        </html>';
    }
}