@section('title')
排行榜
@endsection

@extends('pcview::layouts.default')

@section('styles')
<link rel="stylesheet" href="{{ asset('zhiyicx/plus-component-pc/css/rank.css') }}"/>
@endsection

@section('content')
    <div class="dy_bg fans_bg">
        <div class="dy_cont list_bg">
            <ul class="list_ul">
                <li><a href="{{ route('pc:rank',['mold'=>1]) }}" class="font16 @if($mold == 1) a_border @endif">用户排行榜</a></li>
                <li><a href="{{ route('pc:rank',['mold'=>2]) }}" class="font16 @if($mold == 2) a_border @endif">问答排行榜</a></li>
                <li><a href="{{ route('pc:rank',['mold'=>3]) }}" class="font16 @if($mold == 3) a_border @endif">动态排行榜</a></li>
                <li><a href="{{ route('pc:rank',['mold'=>4]) }}" class="font16 @if($mold == 4) a_border @endif">资讯排行榜</a></li>
            </ul>
            @if($mold == 1)
                <div class="fans_div">
                    @if(!$follower->isEmpty())
                        @include('pcview::templates.rank', ['title' => '粉丝排行榜', 'genre' => 'follower', 'post' => $follower, 'tabName' => '粉丝数'])
                    @endif
                    @if(!$balance->isEmpty())
                        @include('pcview::templates.rank', ['title' => '财富达人排行榜', 'genre' => 'balance', 'post' => $balance])
                    @endif
                    @if(!$income->isEmpty())
                        @include('pcview::templates.rank', ['title' => '收入达人排行榜', 'genre' => 'income', 'post' => $income])
                    @endif
                    @if(!isset($check['message']) && !$check->isEmpty())
                        @include('pcview::templates.rank', ['title' => '社区签到排行榜', 'genre' => 'check', 'post' => $check, 'tabName' => '连续签到'])
                    @endif
                    @if(!$experts->isEmpty())
                        @include('pcview::templates.rank', ['title' => '社区专家排行榜', 'genre' => 'experts', 'post' => $experts])
                    @endif
                    @if(!$likes->isEmpty())
                        @include('pcview::templates.rank', ['title' => '问答达人排行榜', 'genre' => 'likes', 'post' => $likes, 'tabName' => '问答点赞量'])
                    @endif
                </div>
            @elseif($mold == 2)     {{--解答排行榜--}}
                <div class="fans_div">
                    @if(!$answers_day->isEmpty())
                        @include('pcview::templates.rank', ['title' => '今日解答排行榜', 'genre' => 'answers_day', 'post' => $answers_day, 'tabName' => '问答量'])
                    @endif
                    @if(!$answers_week->isEmpty())
                        @include('pcview::templates.rank', ['title' => '一周解答排行榜', 'genre' => 'answers_week', 'post' => $answers_week, 'tabName' => '问答量'])
                    @endif
                    @if(!$answers_month->isEmpty())
                        @include('pcview::templates.rank', ['title' => '本月解答排行榜', 'genre' => 'answers_month', 'post' => $answers_month, 'tabName' => '问答量'])
                    @endif
                </div>
            @elseif($mold == 3)     {{--动态排行榜--}}
                <div class="fans_div">
                    @if(!$feeds_day->isEmpty())
                        @include('pcview::templates.rank', ['title' => '今日动态排行榜', 'genre' => 'feeds_day', 'post' => $feeds_day, 'tabName' => '点赞量'])
                    @endif
                    @if(!$feeds_week->isEmpty())
                        @include('pcview::templates.rank', ['title' => '一周动态排行榜', 'genre' => 'feeds_week', 'post' => $feeds_week, 'tabName' => '点赞量'])
                    @endif
                    @if(!$feeds_month->isEmpty())
                        @include('pcview::templates.rank', ['title' => '本月动态排行榜', 'genre' => 'feeds_month', 'post' => $feeds_month, 'tabName' => '点赞量'])
                    @endif
                </div>
            @elseif($mold == 4)     {{--资讯排行榜--}}
            <div class="fans_div">
                @if(!$news_day->isEmpty())
                    @include('pcview::templates.rank', ['title' => '今日资讯排行榜', 'genre' => 'news_day', 'post' => $news_day, 'tabName' => '浏览量'])
                @endif
                @if(!$news_week->isEmpty())
                    @include('pcview::templates.rank', ['title' => '一周资讯排行榜', 'genre' => 'news_week', 'post' => $news_week, 'tabName' => '浏览量'])
                @endif
                @if(!$news_month->isEmpty())
                    @include('pcview::templates.rank', ['title' => '本月资讯排行榜', 'genre' => 'news_month', 'post' => $news_month, 'tabName' => '浏览量'])
                @endif
            </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function gorank(action,genre,num) {
            var current = $('div[rel="'+genre+'div"][current="1"]');
            //当前页数
            var curnum = $('#'+genre+'num').text();

            //向前
            if ( action == 1 ){
                curnum = parseInt(curnum) - 1;
            } else {
                //向后翻页
                curnum = parseInt(curnum) + 1;
            }
            var last = $('div[rel="'+genre+'div"][current="1"]').prev();
            var postArgs = {};
            postArgs.offset = (curnum - 1) * num;
            if (postArgs.offset >= 100) {

                noticebox('已无更多啦', 0);

                return false;
            } else if (postArgs.offset <= 0) {

                return false;
            }

            postArgs.limit = num;
            postArgs.genre = genre;
            if ( last != undefined ) {
                $.ajax({
                    url: SITE_URL + '/rank/rankList',
                    type: 'GET',
                    data: postArgs,
                    dataType: 'json',
                    error: function (xml) {
                    },
                    success: function (res) {
                        if (res.status) {
                            if (res.data.count == 0) {
                                //noticebox('已无更多啦', 0);
                            } else {
                                $('#'+genre+'-rank-list').html(res.data.html);
                                $('#'+genre+'num').text(curnum);
                            }
                        }
                        return false;
                    }
                });
            }
        }
    </script>
@endsection