@extends('frontend.layouts.master')

@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}" />
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}" />
@endsection

@section('content')
    <main  >
        <!-- banner-part start  -->

        <div class="profile_bg" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.Blog')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->



        <!-- blog part start -->

        <section class="blog blog_two">
            <div class="container">


                <div class="row g-4">
                    @forelse($blogs as $blog)
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xxl-4">
                        <div class="blog_item">
                            <div class="blog_item_thumb_main">
                                <div class="blog_item_thumb">
                                    <img src="{{asset($blog->image)}}" alt="thumb">
                                </div>


                                <div class="blog_item_thumb_over">
                                    <div class="blog_item_thumb_over_txt">
                                        <h6>{{$blog->category->name}}</h6>
                                        <span class="dot"></span>
                                        <p>{{ $blog->created_at->format('F j, Y') }}</p>
                                    </div>

                                </div>


                            </div>

                            <div class="blog_item_inner">
                                <h4>
                                    <a href="{{route('blog.details', $blog->slug)}}">{{$blog->title}}</a>
                                </h4>


                                <a href="{{route('blog.details', $blog->slug)}}" class="blog_inner_btn">
                                    {{__('translate.Read More')}}

                                    <span>
                                        <svg width="5" height="10" viewBox="0 0 5 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M0.443573 0.344988C0.174034 0.560619 0.130333 0.953927 0.345964 1.22347L3.36695 4.9997L0.345964 8.77593C0.130333 9.04547 0.174034 9.43878 0.443573 9.65441C0.713111 9.87004 1.10642 9.82634 1.32205 9.5568L4.65538 5.39013C4.83799 5.16187 4.83799 4.83753 4.65538 4.60926L1.32205 0.442596C1.10642 0.173058 0.713112 0.129357 0.443573 0.344988Z"/>
                                        </svg>

                                    </span>
                                </a>

                            </div>


                        </div>
                    </div>
                    @empty

                    <div class="col-12 text-center">
                        <div class="maintenance-item">
                            <div class="maintenance-thumb">
                                <img src="{{ asset($general_setting->not_found) }}" alt="thumg">
                            </div>

                            <div class="maintenance-item-txt">
                                <h2>{{ __('translate.Sorry!! Blog Not Found') }}</h2>
                                <p>{{ __('translate.Whoops... this information is not available for a moment') }}</p>
                                <a class="thm-btn" href="{{ route('blog') }}">
                                    {{ __('translate.Back to Blog') }}
                                </a>
                            </div>
                        </div>
                    </div>


                    @endforelse

                </div>

                <div class="row">
                    {{ $blogs->links('frontend.layouts.partials.pagination') }}
                </div>

            </div>
        </section>
        <!-- blog part end -->

        <!-- mobile app  part start -->
        @include('frontend.layouts.partials.mobile_app')
        <!-- mobile app  part end -->


    </main>
@endsection
