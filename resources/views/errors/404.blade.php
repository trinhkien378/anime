@extends('themes::layout')
@php
    $menu = \Ophim\Core\Models\Menu::getTree();
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_week', 'desc', 4, 'top_text']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp
    <style>
       

        body {
            background-color: #f3f3f3;
            font-family: Arial, sans-serif;
        }
        .agileits-main {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .agileinfo-row {
            text-align: center;
        }
        .w3layouts-errortext h2 {
            font-size: 200px;
            color: #333;
            margin: 0;
        }
        .w3layouts-errortext h2 span {
            color: #f00;
        }
        .w3layouts-errortext h1 {
            font-size: 36px;
            color: #333;
            margin: 20px 0;
        }
        .w3lstext {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }
        .w3top-nav-right ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        .w3top-nav-right ul li {
            margin: 0 10px;
        }
        .w3top-nav-right ul li a {
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }
        .back-to-home-btn {
            background-color: #ff0000; /* KhoPhimZ.Net */
            color: #fff; /* KhoPhimZ.Net */
            border: none; /* KhoPhimZ.Net */
            padding: 10px 20px; /* KhoPhimZ.Net */
            font-size: 16px; /* PhimHotz.Net */
            cursor: pointer; /* PhimHotz.Net*/
        }
    </style>
@push('header')
    <link rel='stylesheet' id='global-styles-inline-css' href='{{asset('themes/toro/css/global-styles.css')}}?ver=1.0.0' type='text/css'/>
    <link rel='stylesheet' id='TOROFLIX_Theme-css' href='{{asset('themes/toro/css/toroflix-public.css')}}?ver=1.0.0' type='text/css' media='all'/>
    <link rel='stylesheet' id='tp_style_css' href='{{asset('themes/toro/css/tp_style.css')}}?ver=1.0.0' type='text/css' media='all'/>
@endpush

@section('body')
    <div id='shadow'></div>
    <div class="mainholder">
        @include('themes::themetoro.inc.header')
<div class="Main Container"> <section class="error-404 not-found AAIco-sentiment_very_dissatisfied" style="margin-top: 100px;"> <header class="Top">
     <h1 class="Title">Rất tiếc! Không thể tìm thấy trang đó.</h1> <p>Có vẻ như không có gì được tìm thấy ở vị trí này. Có thể thử một trong các liên kết dưới đây hoặc tìm kiếm?</p> 
     </header> <aside class="page-content">
 </div> </aside> </section> </div>
        <!--{!! get_theme_option('footer') !!}-->
    </div>
@endsection

@push('scripts')
@endpush

@section('footer')
    {!! get_theme_option('footer') !!}
    @if (get_theme_option('ads_catfish'))
        {!! get_theme_option('ads_catfish') !!}
    @endif

    <link rel='stylesheet' id='font-awesome-public_css-css'
          href='{{asset('themes/toro/css/font-awesome.css')}}?ver=1.0.0'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='material-public-css-css'
          href='{{asset('themes/toro/css/material.css')}}?ver=1.0.0'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='font-source-sans-pro-public-css-css'
          href='https://fonts.googleapis.com/css?family=Source+Sans+Pro%3A300%2C400%2C600%2C700&#038;ver=1.0.0'
          type='text/css' media='all'/>
    <script type="text/javascript"
            src='{{asset('themes/toro/js/jquery.js')}}?ver=3.0.0'
            id='funciones_public_jquery-js'></script>
    <script type="text/javascript"
            src='{{asset('themes/toro/js/owl.carousel.min.js')}}?ver=1.0.0'
            id='funciones_public_carousel-js'></script>

    <script type="text/javascript" id='funciones_public_sol-js-extra'>
        var toroflixPublic = {"url":"/","nonce":"7a0fde296e","trailer":"","noItemsAvailable":"No entries found","selectAll":"Select all","selectNone":"Select none","searchplaceholder":"Click here to search","loadingData":"Still loading data...","viewmore":"View more","id":"","type":"","report_text_reportForm":"Report Form","report_text_message":"Message","report_text_send":"SEND","report_text_has_send":"the report has been sent","playerAutomaticSlider":"1"};
    </script>

    <script type="text/javascript"
            src='{{asset('themes/toro/js/sol.js')}}?ver=1.0.0'
            id='funciones_public_sol-js'></script>
    <script type="text/javascript"
            src='{{asset('themes/toro/js/functions.js')}}?ver=1.0.0'
            id='funciones_public_functions-js'></script>

    {!! setting('site_scripts_google_analytics') !!}
@endsection
