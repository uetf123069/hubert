
@extends('admin.adminLayout')

@section('content')

@include('notification.notify')

<?php 

$timezone = array (
    '(UTC-11:00) Midway Island' => 'Pacific/Midway',
    '(UTC-11:00) Samoa' => 'Pacific/Samoa',
    '(UTC-10:00) Hawaii' => 'Pacific/Honolulu',
    '(UTC-09:00) Alaska' => 'US/Alaska',
    '(UTC-08:00) Pacific Time (US &amp; Canada)' => 'America/Los_Angeles',
    '(UTC-08:00) Tijuana' => 'America/Tijuana',
    '(UTC-07:00) Arizona' => 'US/Arizona',
    '(UTC-07:00) Chihuahua' => 'America/Chihuahua',
    '(UTC-07:00) Mazatlan' => 'America/Mazatlan',
    '(UTC-07:00) Mountain Time (US &amp; Canada)' => 'US/Mountain',
    '(UTC-06:00) Central America' => 'America/Managua',
    '(UTC-06:00) Central Time (US &amp; Canada)' => 'US/Central',
    '(UTC-06:00) Mexico City' => 'America/Mexico_City',
    '(UTC-06:00) Monterrey' => 'America/Monterrey',
    '(UTC-06:00) Saskatchewan' => 'Canada/Saskatchewan',
    '(UTC-05:00) Bogota' => 'America/Bogota',
    '(UTC-05:00) Eastern Time (US &amp; Canada)' => 'US/Eastern',
    '(UTC-05:00) Indiana (East)' => 'US/East-Indiana',
    '(UTC-05:00) Lima' => 'America/Lima',
    '(UTC-05:00) Quito' => 'America/Bogota',
    '(UTC-04:00) Atlantic Time (Canada)' => 'Canada/Atlantic',
    '(UTC-04:30) Caracas' => 'America/Caracas',
    '(UTC-04:00) La Paz' => 'America/La_Paz',
    '(UTC-04:00) Santiago' => 'America/Santiago',
    '(UTC-03:30) Newfoundland' => 'Canada/Newfoundland',
    '(UTC-03:00) Brasilia' => 'America/Sao_Paulo',
    '(UTC-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
    '(UTC-03:00) Greenland' => 'America/Godthab',
    '(UTC-02:00) Mid-Atlantic' => 'America/Noronha',
    '(UTC-01:00) Azores' => 'Atlantic/Azores',
    '(UTC-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
    '(UTC+00:00) Casablanca' => 'Africa/Casablanca',
    '(UTC+00:00) Greenwich Mean Time : Dublin' => 'Etc/Greenwich',
    '(UTC+00:00) Lisbon' => 'Europe/Lisbon',
    '(UTC+00:00) London' => 'Europe/London',
    '(UTC+00:00) Monrovia' => 'Africa/Monrovia',
    '(UTC+00:00) UTC' => 'UTC',
    '(UTC+01:00) Amsterdam' => 'Europe/Amsterdam',
    '(UTC+01:00) Belgrade' => 'Europe/Belgrade',
    '(UTC+01:00) Berlin' => 'Europe/Berlin',
    '(UTC+01:00) Bratislava' => 'Europe/Bratislava',
    '(UTC+01:00) Brussels' => 'Europe/Brussels',
    '(UTC+01:00) Budapest' => 'Europe/Budapest',
    '(UTC+01:00) Copenhagen' => 'Europe/Copenhagen',
    '(UTC+01:00) Ljubljana' => 'Europe/Ljubljana',
    '(UTC+01:00) Madrid' => 'Europe/Madrid',
    '(UTC+01:00) Paris' => 'Europe/Paris',
    '(UTC+01:00) Prague' => 'Europe/Prague',
    '(UTC+01:00) Rome' => 'Europe/Rome',
    '(UTC+01:00) Sarajevo' => 'Europe/Sarajevo',
    '(UTC+01:00) Skopje' => 'Europe/Skopje',
    '(UTC+01:00) Stockholm' => 'Europe/Stockholm',
    '(UTC+01:00) Vienna' => 'Europe/Vienna',
    '(UTC+01:00) Warsaw' => 'Europe/Warsaw',
    '(UTC+01:00) West Central Africa' => 'Africa/Lagos',
    '(UTC+01:00) Zagreb' => 'Europe/Zagreb',
    '(UTC+02:00) Athens' => 'Europe/Athens',
    '(UTC+02:00) Bucharest' => 'Europe/Bucharest',
    '(UTC+02:00) Cairo' => 'Africa/Cairo',
    '(UTC+02:00) Harare' => 'Africa/Harare',
    '(UTC+02:00) Helsinki' => 'Europe/Helsinki',
    '(UTC+02:00) Istanbul' => 'Europe/Istanbul',
    '(UTC+02:00) Jerusalem' => 'Asia/Jerusalem',
    '(UTC+02:00) Pretoria' => 'Africa/Johannesburg',
    '(UTC+02:00) Riga' => 'Europe/Riga',
    '(UTC+02:00) Sofia' => 'Europe/Sofia',
    '(UTC+02:00) Tallinn' => 'Europe/Tallinn',
    '(UTC+02:00) Vilnius' => 'Europe/Vilnius',
    '(UTC+03:00) Baghdad' => 'Asia/Baghdad',
    '(UTC+03:00) Kuwait' => 'Asia/Kuwait',
    '(UTC+03:00) Minsk' => 'Europe/Minsk',
    '(UTC+03:00) Nairobi' => 'Africa/Nairobi',
    '(UTC+03:00) Riyadh' => 'Asia/Riyadh',
    '(UTC+03:00) Volgograd' => 'Europe/Volgograd',
    '(UTC+03:30) Tehran' => 'Asia/Tehran',
    '(UTC+04:00) Abu Dhabi' => 'Asia/Muscat',
    '(UTC+04:00) Baku' => 'Asia/Baku',
    '(UTC+04:00) Moscow' => 'Europe/Moscow',
    '(UTC+04:00) Tbilisi' => 'Asia/Tbilisi',
    '(UTC+04:00) Yerevan' => 'Asia/Yerevan',
    '(UTC+04:30) Kabul' => 'Asia/Kabul',
    '(UTC+05:00) Karachi' => 'Asia/Karachi',
    '(UTC+05:00) Tashkent' => 'Asia/Tashkent',
    '(UTC+05:30) New Delhi' => 'Asia/Calcutta',
    '(UTC+05:45) Kathmandu' => 'Asia/Katmandu',
    '(UTC+06:00) Almaty' => 'Asia/Almaty',
    '(UTC+06:00) Dhaka' => 'Asia/Dhaka',
    '(UTC+06:00) Ekaterinburg' => 'Asia/Yekaterinburg',
    '(UTC+06:30) Rangoon' => 'Asia/Rangoon',
    '(UTC+07:00) Bangkok' => 'Asia/Bangkok',
    '(UTC+07:00) Jakarta' => 'Asia/Jakarta',
    '(UTC+07:00) Novosibirsk' => 'Asia/Novosibirsk',
    '(UTC+08:00) Chongqing' => 'Asia/Chongqing',
    '(UTC+08:00) Hong Kong' => 'Asia/Hong_Kong',
    '(UTC+08:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
    '(UTC+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
    '(UTC+08:00) Perth' => 'Australia/Perth',
    '(UTC+08:00) Singapore' => 'Asia/Singapore',
    '(UTC+08:00) Taipei' => 'Asia/Taipei',
    '(UTC+08:00) Ulaan Bataar' => 'Asia/Ulan_Bator',
    '(UTC+08:00) Urumqi' => 'Asia/Urumqi',
    '(UTC+09:00) Irkutsk' => 'Asia/Irkutsk',
    '(UTC+09:00) Seoul' => 'Asia/Seoul',
    '(UTC+09:00) Tokyo' => 'Asia/Tokyo',
    '(UTC+09:30) Adelaide' => 'Australia/Adelaide',
    '(UTC+09:30) Darwin' => 'Australia/Darwin',
    '(UTC+10:00) Brisbane' => 'Australia/Brisbane',
    '(UTC+10:00) Canberra' => 'Australia/Canberra',
    '(UTC+10:00) Guam' => 'Pacific/Guam',
    '(UTC+10:00) Hobart' => 'Australia/Hobart',
    '(UTC+10:00) Melbourne' => 'Australia/Melbourne',
    '(UTC+10:00) Port Moresby' => 'Pacific/Port_Moresby',
    '(UTC+10:00) Sydney' => 'Australia/Sydney',
    '(UTC+10:00) Yakutsk' => 'Asia/Yakutsk',
    '(UTC+11:00) Vladivostok' => 'Asia/Vladivostok',
    '(UTC+12:00) Auckland' => 'Pacific/Auckland',
    '(UTC+12:00) Fiji' => 'Pacific/Fiji',
    '(UTC+12:00) International Date Line West' => 'Pacific/Kwajalein',
    '(UTC+12:00) Kamchatka' => 'Asia/Kamchatka',
    '(UTC+12:00) Magadan' => 'Asia/Magadan',
    '(UTC+12:00) Wellington' => 'Pacific/Auckland',
    '(UTC+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
);
 ?>

<div class="page">

    <div class="col-md-8">
        <div class="card">
            <div class="card-head style-primary">
                        <header>{{ tr('website_settings') }}</header>
                    </div>
            <div class="card-body">
                <form class="form" action="{{route('adminSettingProcess')}}" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="sitename" value="{{Setting::get('sitename')}}">
                        <label for="regular1">{{ tr('site_title') }}</label>
                    </div>

                   <!--  <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="footer" value="{{Setting::get('footer')}}">
                        <label for="regular1">Footer</label>￼
                    </div> -->

                    <div class="file-field input-field col s12">
                        <div class="tile-content">
                                <div class="tile-icon brand-logo">
                                    <img  src="{{Setting::get('logo')}}" alt="">
                                </div>
                            </div>
                        <div class="btn light-blue accent-2" style="padding: 0px 10px;">
                            <span>{{ tr('choose_logo') }}</span>
                            <input type="file" name="picture" />
                        </div>
                        <input class="file-path validate" type="text"/>

                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="browser_key" value="{{Setting::get('browser_key')}}">
                        <label for="regular1"> {{ tr('browser_key') }}</label>
                    </div>

                    <div class="form-group">
                      <textarea id="textarea1" class="materialize-textarea" name="analytics_code">{{Setting::get('analytics_code')}}</textarea>
                      <label for="textarea1">{{ tr('google_analytics_code') }}</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="google_play" value="{{Setting::get('google_play')}}">
                        <label for="regular1">{{ tr('google_playstore_link') }}</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="ios_app" value="{{Setting::get('ios_app')}}">
                        <label for="regular1">{{ tr('apple_app_store_link') }}</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="website_link" value="{{Setting::get('website_link')}}">
                        <label for="regular1">{{ tr('website_link') }}</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="search_radius" value="{{Setting::get('search_radius')}}">
                        <label for="regular1">{{ tr('search_radius') }}</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="like_limit_count" value="{{Setting::get('like_limit_count')}}">
                        <label for="regular1">{{ tr('like_limit_count') }}</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="superlike_limit_count" value="{{Setting::get('superlike_limit_count')}}">
                        <label for="regular1">{{ tr('superlike_limit_count') }}</label>
                    </div>

                    <div class="form-group floating-label">
                            <select id="cat_select" name="timezone" class="form-control" required>
                                <option value="">{{ tr('select_timezone') }}</option>
                                @foreach($timezone as $key => $value)
                                    <option value="{{$value}}" <?php if($value == Setting::get('timezone')) echo "selected"; ?> >{{$key}}</option>
                                @endforeach

                            </select>
                            <label for="cat_select">{{ tr('select_timezone') }}</label>

                        </div>
                        <br>
                    <button type="submit" class="btn ink-reaction btn-raised btn-info">
                        {{tr('admin_submit')}}
                    </button>
                </form>
            </div><!--end .card-body -->
        </div><!--end .card -->

    </div>


      <div class="col-md-4">
        <div class="card">
            <div class="card-head style-primary">
                        <header>{{tr('email_config') }}</header>
                    </div>
            <div class="card-body">
                <form>
                    <div class="col-sm-9">
                        <label class="radio-inline radio-styled radio-primary">
                            <input type="radio" id="normal_smtp" name="mail_conf"><span>Normal SMTP</span>
                        </label>
                        <label class="radio-inline radio-styled radio-primary">
                            <input type="radio" id="mandrill" name="mail_conf"><span>Mandrill</span>
                        </label>
                    </div>
                </form>
            </div>

            <div class="card-body" id="mail_config">
                
                <form class="form" action="{{route('mailConfig')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="mail_type" value="normal_smtp"> 
                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="username" value="{{Setting::get('username')}}">
                        <label for="regular1">{{ tr('admin_username') }}</label>
                    </div>

                    <div class="form-group">
                        <input class="form-control" id="regular1" name="password" type="password">
                        <label for="regular1">{{ tr('password') }}</label>
                    </div>

                    <button type="submit" class="btn ink-reaction btn-raised btn-info">
                        {{ tr('admin_submit') }}
                    </button>
                </form>
            </div><!--end .card-body -->

             <div class="card-body" id="mail_config1">
                
                <form class="form" action="{{route('mailConfig')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="mail_type" value="mandrill"> 
                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="username" >
                        <label for="regular1">{{ tr('mandrill_username') }}</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="password">
                        <label for="regular1">{{ tr('mandrill_secret') }}</label>
                    </div>

                    <button type="submit" class="btn ink-reaction btn-raised btn-info">
                        {{ tr('admin_submit') }}
                    </button>
                </form>
            </div><!--end .card-body -->
        </div><!--end .card -->

    </div>    


</div>
</div>



@stop


<script src="{{asset('admins/js/libs/jquery/jquery-1.11.2.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#mail_config').hide();
        $('#mail_config1').hide();

        $("#normal_smtp").click(function(){
        $("#mail_config").show();
        $("#mail_config1").hide();
        });

        $("#mandrill").click(function(){
        $("#mail_config1").show();
        $("#mail_config").hide();
        });
    });


</script>



