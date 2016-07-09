<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>独白</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/> 
        <link rel="stylesheet" href="http://cdn.bootcss.com/fullPage.js/2.7.2/jquery.fullPage.min.css">  
        <!-- HTML5 Shim and Respond.js')}} IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="http://cdn.bootcss.com/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
            <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .banner{
                background: url({{asset('public/img/bg1.jpg')}}) 100% 0 no-repeat; 
                } 
                .download{
                    background-color: #f8f8f8;
                } 
                .center{
                    display: table;
                    margin-left: auto; 
                    margin-right: auto;
                } 
                .code{ 
                    width:400px;
                    height:400px; 
                } 
                .phone{
                    position: absolute;
                    width:300px;
                    height:500px;
                    bottom:0px;  
                    left:30%;
                } 
                .desc { 
                   margin-top: 30px;
                }
                .desc h1{ 
                    font-family: "黑体";
                    color: #484848; 
                    text-align: center;
                    font-weight: lighter;
                }
                .group span{
                    position: absolute;
                    bottom: 5px; 
                    left:5px;
                    color: #5f5f5f;
                    font-size:8px; 
                }
                @media screen and (max-width:768px) { 
                    .phone{
                        position: absolute; 
                        bottom:0px;  
                        width:300px;
                        height:500px;
                        left:30%;
                    } 
                    .code{ 
                        width:200px;
                        height:200px; 
                    } 
                }
                @media screen and (max-width:414px) { 
                    .phone{
                        position: absolute; 
                        bottom:0px;   
                        width:250px;
                        height:400px;
                        left:13%;
                    } 
                }
                @media screen and (min-width:1080px) {
                    .phone{
                        position: absolute; 
                        bottom:0px; 
                        left:42%;
                    }
                }
            </style> 
        </head>
        <body >   
            <div id="pages">  
                <div class="section banner"> 
                    <div class="center icon">
                        <img src="{{asset('public/img/logo.png')}}"> 
                    </div> 
                    <div class="description">
                        <img class="phone"  src="{{asset('public/img/phone1.png')}}"/>
                    </div> 
                </div>   
                <div class="section download"> 
                    <div class="center icon">
                        <img src="{{asset('public/img/logo.png')}}"> 
                    </div> 
                    <div class="center">
                        <div class="desc">
                            <img class="code" src="{{asset('public/img/box.png')}}"/>
                            <h1>Android下载</h1> 
                        </div>
                    </div> 
                    <div class="group">
                        <span>慧积木合  &copy;2015-2016</span>
                    </div>
                </div>  
            </div>  
            <!-- jQuery 1.11.3 -->
            <script src="http://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script> 
            <!-- fullpage.js 2.7.2 -->
            <script src="http://cdn.bootcss.com/fullPage.js/2.7.2/jquery.fullPage.min.js"></script>  
            <script>
$(function() {
    var $monologNav = $('#icon');
    $('#pages').fullpage({
        verticalCentered: !1,
        navigation: !0,
    });
});
            </script>
        </body>
    </html> 
