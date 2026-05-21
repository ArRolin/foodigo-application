@extends('frontend.layouts.master')

@section('title')
    <title>{{ $blog->seo_title }}</title>
    <meta name="title" content="{{ $blog->seo_title }}">
    <meta name="description" content="{{ $blog->seo_description }}">

    @php
        $tags = '';
        if($blog->tags){
            foreach (json_decode($blog->tags) as $key => $blog_tag) {
                $tags .= $blog_tag->value.', ';
            }
        }
    @endphp

    <meta name="keyword" content="{{ $tags }}">
@endsection

@section('content')
    <main>
        <!-- banner-part start  -->

        <div class="profile_bg" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="{{ route('blog') }}">{{__('translate.Blog')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{ $blog->slug }} </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->

        <!-- Blog Details part start  -->

        <section class="blog_details">
            <div class="container">
                <div class="row ">
                    <div class=" col-xl-8 col-xxl-8">
                        <div class="blog_details_top_txt">
                            <h2>{{$blog->title}}</h2>
                        </div>

                        <div class="blog_details_thumb">
                            <img src="{{asset($blog->image)}}" alt="thumb">
                        </div>


                        <div class="blog_details_p">
                            {!! clean($blog->description) !!}
                        </div>


                        <div class="taga_share_main">
                            <ul class="tag_item">
                                <li>{{ __('translate.Tags') }}:</li>
                                @forelse(json_decode($blog->tags, true) as $tag)
                                <li><a href="javascript:;">#{{$tag['value']}}</a></li>
                                @empty
                                @endforelse
                            </ul>

                            <ul class="share_item">
                                <li>{{__('translate.Share')}}:</li>
                                <li>
                                    <a href="https://twitter.com/share?text={{ $blog->title }}&url={{ route('blog.details', $blog->slug) }}" target="_blank">
                                        <span>
                                            <svg width="12" height="12" viewBox="0 0 19 17" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.7642 0C10.5722 0 8.7953 1.86585 8.7953 4.1675C8.7953 4.5153 8.83587 4.85315 8.91232 5.17611C6.80469 5.17611 3.63013 4.74999 0.978868 2.09376C0.626315 1.74054 -0.0237835 1.9767 0.000670803 2.47516C0.393588 10.484 3.82353 12.8202 5.58986 12.9656C4.44926 14.0921 2.79242 14.9813 1.1252 15.3804C0.685191 15.4857 0.576494 15.9674 1.00675 16.1073C2.19973 16.4953 3.90729 16.6448 4.82642 16.67C11.3286 16.67 16.6134 11.1972 16.731 4.3991C17.5847 3.84394 18.1315 2.63855 18.4388 1.78464C18.5136 1.57667 18.1728 1.33436 17.9687 1.41931C17.331 1.68479 16.5214 1.74773 15.8318 1.52302C15.1039 0.593104 14 0 12.7642 0Z"/>
                                            </svg>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('blog.details', $blog->slug) }}&title={{ $blog->title }}" target="_blank">
                                        <span>
                                            <svg width="12" height="12" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2ZM4 6.5V20H0V6.5H4ZM7 6.5H11V7.34141C11.6256 7.12031 12.2987 7 13 7C16.3137 7 19 9.68629 19 13V20H15V13C15 11.8954 14.1046 11 13 11C11.8954 11 11 11.8954 11 13V20H7V13V6.5Z" />
                                                </svg>


                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('blog.details', $blog->slug) }}&t={{ $blog->title }}" target="_blank">
                                        <span>
                                            <svg width="12" height="12" viewBox="0 0 11 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10.6667 0H8.55556C5.79413 0 3.55556 2.23857 3.55556 5V6.22222H0V9.77778H3.55556V16H7.11111V9.77778H10.6667V6.22222H7.11111V4.55556C7.11111 4.00327 7.55883 3.55556 8.11111 3.55556H10.6667V0Z"/>
                                            </svg>

                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a  href="https://www.pinterest.com/pin/create/button/?description={{ $blog->title }}&media=&url={{ route('blog.details', $blog->slug) }}" target="_blank">
                                        <span class="svg-two">

                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.48963 1.22969C8.66362 0.43673 7.52051 0 6.2709 0C4.36204 0 3.18801 0.782467 2.53927 1.43884C1.73973 2.24774 1.28125 3.3218 1.28125 4.38568C1.28125 5.72145 1.83997 6.74671 2.77563 7.12813C2.83844 7.15387 2.90165 7.16683 2.96361 7.16683C3.161 7.16683 3.3174 7.03768 3.37158 6.8305C3.40317 6.71164 3.47635 6.41842 3.50817 6.29113C3.57629 6.03975 3.52125 5.91884 3.37271 5.74378C3.10209 5.42359 2.97607 5.04495 2.97607 4.55218C2.97607 3.0885 4.06596 1.53289 6.08597 1.53289C7.68876 1.53289 8.6844 2.44385 8.6844 3.91025C8.6844 4.83561 8.48508 5.69258 8.12305 6.32341C7.87148 6.76172 7.4291 7.28422 6.74997 7.28422C6.45629 7.28422 6.19248 7.16358 6.02602 6.95327C5.86877 6.75445 5.81694 6.49761 5.88019 6.22994C5.95163 5.92751 6.04905 5.61204 6.14333 5.30705C6.31529 4.75003 6.47784 4.22394 6.47784 3.8042C6.47784 3.08625 6.03647 2.60385 5.37963 2.60385C4.54488 2.60385 3.89091 3.45169 3.89091 4.53403C3.89091 5.06485 4.03198 5.46187 4.09584 5.61432C3.99068 6.05987 3.3657 8.70878 3.24715 9.20828C3.17861 9.49988 2.76568 11.8029 3.44915 11.9866C4.21706 12.1929 4.90347 9.94988 4.97333 9.69641C5.02995 9.49028 5.22807 8.71083 5.34948 8.23168C5.72019 8.58876 6.31707 8.83015 6.89785 8.83015C7.99274 8.83015 8.97739 8.33746 9.67045 7.4429C10.3426 6.57525 10.7128 5.36592 10.7128 4.03785C10.7128 2.99959 10.2669 1.97604 9.48963 1.22969Z" fill="black"/>
                                                </svg>







                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>


                        @if($blog->comments->count() > 0)
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="comment_txt">
                                    <h2>{{ __('translate.Comments') }} ({{$blog->comments->count()}})</h2>
                                </div>

                                <div class="comment_item_main">
                                    @foreach($blog->comments as $comment)
                                    <div class="comment_item_main_inner">
                                        <div class="comment_item">
                                            <div class="comment_item_thumb">
                                                <img src="{{ asset($general_setting->default_avatar) }}" alt="thumb">
                                            </div>

                                            <div class="comment_item_txt">
                                                <div class="comment_item_txt_item">
                                                    <a href="javascript:;">{{html_decode($comment->name)}}</a>
                                                    <p>{{ $comment->created_at->format('F j, Y') }}</p>
                                                </div>

                                                <div class="comment_item_txt_p">
                                                    <p>
                                                        {{html_decode($comment->comment)}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </div>

                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="reply_box">
                                    <div class="reply_box_head">
                                        <h2>{{__('translate.Leave a Comment')}}</h2>
                                        <p>
                                            {{__('translate.Your email address will not be published.')}}
                                        </p>
                                    </div>

                                    <form class="reply_form" action="{{route('blog.comment', $blog->id)}}" method="post">
                                        @csrf
                                        <div class="reply_form_item">
                                            <div class="reply_form_inner">
                                                <input type="text" class="form-control" id="exampleFormControlInput4"
                                                       placeholder="Name" name="name">
                                            </div>
                                            <div class="reply_form_inner">
                                                <input type="email" class="form-control" id="exampleFormControlInput2"
                                                       placeholder="Email" name="email">
                                            </div>
                                        </div>
                                        <div class="reply_form_item">
                                            <div class="reply_form_inner">
                                                <textarea class="form-control" id="exampleFormControlTextarea3" rows="3"
                                                          placeholder="Comments" name="comment"></textarea>
                                            </div>
                                        </div>


                                        @if($general_setting->recaptcha_status==1)
                                            <div class="reply_form_item">
                                                <div class="reply_form_inner">
                                                    <div class="g-recaptcha" data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="reply_form_item">
                                            <div class="reply_form_inner">
                                                <button type="submit" class="thm-btn">{{__('translate.Submit')}}</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class=" col-xl-4 col-xxl-4">
                        <div class="blog_details_sarch_box">
                            <form class="blog_details_sarch" action="{{ route('blog') }}">
                                <input type="text" class="form-control" id="search"
                                       placeholder="{{ __('translate.Search') }}" name="search">

                                <button type="submit" class="sarch_btn">
                                    <span>
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M15.8724 8.58329C15.8724 12.6104 12.6078 15.875 8.58073 15.875C4.55365 15.875 1.28906 12.6104 1.28906 8.58329C1.28906 4.55622 4.55365 1.29163 8.58073 1.29163C12.6078 1.29163 15.8724 4.55622 15.8724 8.58329ZM8.58073 17.125C13.2982 17.125 17.1224 13.3007 17.1224 8.58329C17.1224 3.86586 13.2982 0.041626 8.58073 0.041626C3.8633 0.041626 0.0390625 3.86586 0.0390625 8.58329C0.0390625 13.3007 3.8633 17.125 8.58073 17.125ZM16.106 15.2247C15.8619 14.9806 15.4662 14.9806 15.2221 15.2247C14.978 15.4688 14.978 15.8645 15.2221 16.1086L16.8888 17.7752C17.1328 18.0193 17.5286 18.0193 17.7727 17.7752C18.0167 17.5311 18.0167 17.1354 17.7727 16.8913L16.106 15.2247Z" />
                                        </svg>

                                    </span>
                                </button>
                            </form>
                        </div>


                        <div class="blog_details_item_box">
                            <div class="blog_details_item_box_txt">
                                <h4>{{__('translate.Category')}} </h4>
                            </div>
                            <ul class="blog_details_catagory">
                                @foreach($categories as $category)
                                <li> <a href="{{ route('blog', ['category' => $category->id]) }}">{{$category->name}} <span>({{$category->blogs_count}})</span></a> </li>
                               @endforeach
                            </ul>
                        </div>


                        <div class="blog_details_item_box">
                            <div class="blog_details_item_box_txt">
                                <h4>{{__('translate.Latest Blog')}} </h4>
                            </div>

                            <div class="latest_blog">
                                @forelse($latest_blogs as $latest_blog)
                                <div class="latest_blog_item">
                                    <div class="latest_blog_thumb">
                                        <img src="{{asset($latest_blog->image)}}" alt="thumb">
                                    </div>

                                    <div class="latest_blog_txt">

                                        <h5>
                                            <a href="{{route('blog.details', $latest_blog->slug)}}">
                                                {{$latest_blog->title}}
                                            </a>
                                        </h5>

                                        <p>
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.9894 3.25799C17.9894 5.27443 17.9894 7.29086 17.9894 9.30729C17.941 9.26327 17.897 9.21924 17.8486 9.17962C17.4833 8.85382 17.1225 8.51921 16.7485 8.20222C16.634 8.10536 16.5768 8.02611 16.5812 7.87202C16.5944 7.45376 16.5856 7.0311 16.5856 6.60844C11.5162 6.60844 6.46879 6.60844 1.40817 6.60844C1.40817 6.68329 1.40817 6.74933 1.40817 6.81097C1.40817 9.78719 1.40817 12.7634 1.40817 15.7396C1.40817 16.312 1.6722 16.5805 2.24428 16.5805C4.0617 16.5805 5.87472 16.5893 7.69214 16.5717C7.99138 16.5673 8.1982 16.629 8.32142 16.9063C8.34782 16.9636 8.39623 17.012 8.44024 17.0604C8.73067 17.3686 9.02551 17.6812 9.31594 17.9894C6.83404 17.9894 4.35213 17.9894 1.86583 17.9894C1.79102 17.9718 1.72061 17.9542 1.6458 17.9366C0.65568 17.6988 0.00440054 16.8711 0 15.8409C0 13.9345 0 12.0238 0 10.113C0 7.92045 0 5.73231 0 3.53977C0 2.50954 0.65128 1.66422 1.6458 1.45729C2.00225 1.38245 2.37629 1.41326 2.74594 1.39565C2.81194 1.39125 2.87795 1.39565 2.96156 1.39565C2.96156 0.911358 2.96156 0.45788 2.96156 0C3.43242 0 3.89008 0 4.36093 0C4.36093 0.466686 4.36093 0.920163 4.36093 1.38245C7.45451 1.38245 10.5349 1.38245 13.6373 1.38245C13.6373 0.91576 13.6373 0.453477 13.6373 0C14.1169 0 14.5746 0 15.0454 0C15.0454 0.466686 15.0454 0.924566 15.0454 1.39565C15.3491 1.39565 15.6395 1.38685 15.9344 1.39565C16.612 1.42207 17.1577 1.70825 17.5758 2.24537C17.8046 2.54476 17.9102 2.89697 17.9894 3.25799ZM13.6373 2.81332C10.5305 2.81332 7.45011 2.81332 4.35213 2.81332C4.35213 3.28001 4.35213 3.73348 4.35213 4.19577C3.88128 4.19577 3.42362 4.19577 2.94396 4.19577C2.94396 3.72468 2.94396 3.2668 2.94396 2.80011C2.66233 2.80011 2.39829 2.79571 2.13426 2.80011C1.69861 2.80892 1.40817 3.09509 1.40377 3.53096C1.39937 3.95802 1.40377 4.38508 1.40377 4.81214C1.40377 4.93102 1.40377 5.05429 1.40377 5.17316C6.47319 5.17316 11.525 5.17316 16.5812 5.17316C16.5812 4.59201 16.59 4.02406 16.5768 3.45611C16.568 3.12591 16.3216 2.83974 15.9916 2.80892C15.6791 2.7825 15.3623 2.80452 15.0322 2.80452C15.0322 3.2756 15.0322 3.73348 15.0322 4.19136C14.557 4.19136 14.1037 4.19136 13.6373 4.19136C13.6373 3.73348 13.6373 3.28001 13.6373 2.81332Z" />
                                                    <path
                                                        d="M12.9022 17.9869C12.4445 17.8768 11.9648 17.8195 11.5292 17.6478C10.0858 17.0755 9.10449 16.0321 8.70404 14.5307C8.18918 12.6244 8.69084 10.9646 10.1694 9.65255C11.2432 8.69717 12.5281 8.33174 13.9495 8.55628C15.6569 8.82485 16.8758 9.77583 17.5843 11.3388C17.778 11.7614 17.8396 12.2457 17.9628 12.6992C17.9804 12.7609 17.9848 12.8225 17.998 12.8841C17.998 13.1175 17.998 13.3508 17.998 13.5886C17.9364 13.8967 17.9056 14.2137 17.8132 14.5131C17.3731 16.0012 16.4358 17.0623 14.9924 17.639C14.5524 17.8151 14.0683 17.8724 13.6062 17.9869C13.3686 17.9869 13.1354 17.9869 12.9022 17.9869ZM13.2498 16.5824C15.0848 16.5824 16.5898 15.0767 16.5898 13.2407C16.5854 11.4092 15.0936 9.91231 13.263 9.90351C11.428 9.8947 9.91859 11.396 9.91419 13.2363C9.90979 15.0723 11.4148 16.578 13.2498 16.5824Z" />
                                                    <path
                                                        d="M2.67969 9.47263C2.67969 9.00567 2.67969 8.55192 2.67969 8.08496C3.14202 8.08496 3.59554 8.08496 4.06227 8.08496C4.06227 8.53871 4.06227 9.00126 4.06227 9.47263C3.60875 9.47263 3.15082 9.47263 2.67969 9.47263Z" />
                                                    <path
                                                        d="M6.87576 8.08496C6.87576 8.55192 6.87576 9.00567 6.87576 9.46822C6.40903 9.46822 5.95111 9.46822 5.48438 9.46822C5.48438 9.00567 5.48438 8.55192 5.48438 8.08496C5.9423 8.08496 6.40023 8.08496 6.87576 8.08496Z" />
                                                    <path
                                                        d="M9.69508 8.08459C9.69508 8.55156 9.69508 9.0053 9.69508 9.46785C9.23275 9.46785 8.77923 9.46785 8.3125 9.46785C8.3125 9.01411 8.3125 8.55596 8.3125 8.08459C8.76602 8.08459 9.22395 8.08459 9.69508 8.08459Z" />
                                                    <path
                                                        d="M2.67969 12.2788C2.67969 11.8162 2.67969 11.3581 2.67969 10.8955C3.14642 10.8955 3.60434 10.8955 4.07108 10.8955C4.07108 11.3581 4.07108 11.8118 4.07108 12.2788C3.61315 12.2788 3.15523 12.2788 2.67969 12.2788Z" />
                                                    <path
                                                        d="M5.48438 12.2832C5.48438 11.8162 5.48438 11.3625 5.48438 10.8955C5.9467 10.8955 6.40023 10.8955 6.86696 10.8955C6.86696 11.3493 6.86696 11.8118 6.86696 12.2832C6.41344 12.2832 5.95551 12.2832 5.48438 12.2832Z" />
                                                    <path
                                                        d="M2.67969 13.7061C3.14642 13.7061 3.59994 13.7061 4.06227 13.7061C4.06227 14.1686 4.06227 14.6224 4.06227 15.0893C3.60875 15.0893 3.15082 15.0893 2.67969 15.0893C2.67969 14.6356 2.67969 14.1774 2.67969 13.7061Z" />
                                                    <path
                                                        d="M6.87576 13.7168C6.87576 14.1794 6.87576 14.6331 6.87576 15.1001C6.40903 15.1001 5.95111 15.1001 5.48438 15.1001C5.48438 14.6419 5.48438 14.1838 5.48438 13.7168C5.9379 13.7168 6.39582 13.7168 6.87576 13.7168Z" />
                                                    <path
                                                        d="M12.5312 10.8955C12.9977 10.8955 13.451 10.8955 13.9218 10.8955C13.9218 11.4414 13.9218 11.9786 13.9218 12.5333C14.3223 12.5333 14.7095 12.5333 15.11 12.5333C15.11 13.0088 15.11 13.4623 15.11 13.929C14.2607 13.929 13.4026 13.929 12.5312 13.929C12.5312 12.9251 12.5312 11.9169 12.5312 10.8955Z" />
                                                </svg>
                                            </span>

                                            {{ $latest_blog->created_at->format('F j, Y') }}
                                        </p>

                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>



                        <div class="blog_details_item_box">
                            <div class="blog_details_item_box_txt">
                                <h4>{{__('translate.Follow Us')}}</h4>
                            </div>



                            <ul class="blog_details_social_media">
                                <li>
                                    <a href="{{ $footer->twitter }}">
                                        <span>
                                            <svg width="16" height="14" viewBox="0 0 19 17" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.7642 0C10.5722 0 8.7953 1.86585 8.7953 4.1675C8.7953 4.5153 8.83587 4.85315 8.91232 5.17611C6.80469 5.17611 3.63013 4.74999 0.978868 2.09376C0.626315 1.74054 -0.0237835 1.9767 0.000670803 2.47516C0.393588 10.484 3.82353 12.8202 5.58986 12.9656C4.44926 14.0921 2.79242 14.9813 1.1252 15.3804C0.685191 15.4857 0.576494 15.9674 1.00675 16.1073C2.19973 16.4953 3.90729 16.6448 4.82642 16.67C11.3286 16.67 16.6134 11.1972 16.731 4.3991C17.5847 3.84394 18.1315 2.63855 18.4388 1.78464C18.5136 1.57667 18.1728 1.33436 17.9687 1.41931C17.331 1.68479 16.5214 1.74773 15.8318 1.52302C15.1039 0.593104 14 0 12.7642 0Z"/>
                                            </svg>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $footer->linkedin }}">
                                        <span>
                                            <svg width="16" height="14" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2ZM4 6.5V20H0V6.5H4ZM7 6.5H11V7.34141C11.6256 7.12031 12.2987 7 13 7C16.3137 7 19 9.68629 19 13V20H15V13C15 11.8954 14.1046 11 13 11C11.8954 11 11 11.8954 11 13V20H7V13V6.5Z" />
                                                </svg>


                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ $footer->facebook }}">
                                        <span>
                                            <svg width="16" height="14" viewBox="0 0 11 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10.6667 0H8.55556C5.79413 0 3.55556 2.23857 3.55556 5V6.22222H0V9.77778H3.55556V16H7.11111V9.77778H10.6667V6.22222H7.11111V4.55556C7.11111 4.00327 7.55883 3.55556 8.11111 3.55556H10.6667V0Z"/>
                                            </svg>

                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $footer->instagram }}">
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_976_11463)">
                                                    <path
                                                        d="M11.6689 0H4.33105C1.94287 0 0 1.94287 0 4.33105V11.669C0 14.0571 1.94287 16 4.33105 16H11.669C14.0571 16 16 14.0571 16 11.669V4.33105C16 1.94287 14.0571 0 11.6689 0ZM15.062 11.669C15.062 13.5399 13.5399 15.062 11.6689 15.062H4.33105C2.46008 15.062 0.937986 13.5399 0.937986 11.669V4.33105C0.937986 2.46008 2.46008 0.937986 4.33105 0.937986H11.669C13.5399 0.937986 15.062 2.46008 15.062 4.33105V11.669Z" />
                                                    <path
                                                        d="M7.99987 3.62512C5.58752 3.62512 3.625 5.58764 3.625 7.99999C3.625 10.4123 5.58752 12.3749 7.99987 12.3749C10.4122 12.3749 12.3747 10.4123 12.3747 7.99999C12.3747 5.58764 10.4122 3.62512 7.99987 3.62512ZM7.99987 11.4369C6.10485 11.4369 4.56299 9.89513 4.56299 7.99999C4.56299 6.10498 6.10485 4.56311 7.99987 4.56311C9.89501 4.56311 11.4368 6.10498 11.4368 7.99999C11.4368 9.89513 9.89501 11.4369 7.99987 11.4369Z" />
                                                    <path
                                                        d="M12.4802 2.07141C11.7673 2.07141 11.1875 2.65137 11.1875 3.36413C11.1875 4.07702 11.7673 4.65698 12.4802 4.65698C13.1931 4.65698 13.7731 4.07702 13.7731 3.36413C13.7731 2.65124 13.1931 2.07141 12.4802 2.07141ZM12.4802 3.71887C12.2847 3.71887 12.1255 3.55969 12.1255 3.36413C12.1255 3.16845 12.2847 3.0094 12.4802 3.0094C12.6759 3.0094 12.8351 3.16845 12.8351 3.36413C12.8351 3.55969 12.6759 3.71887 12.4802 3.71887Z" />
                                                </g>

                                            </svg>


                                        </span>
                                    </a>
                                </li>

                            </ul>


                        </div>



                        <div class="blog_details_left_ads">
                            @if ($homepage->blog_banner_one_status == 1)
                            <div class="blog_details_left_ads_thumb">
                                <a href="{{ $homepage->blog_banner_one_link }}">
                                    <img src="{{ asset($homepage->blog_banner_one) }}" alt="thumb">
                                </a>
                            </div>
                            @endif

                            @if ($homepage->blog_banner_two_status == 1)
                            <div class="blog_details_left_ads_thumb two">
                                <a href="{{ $homepage->blog_banner_two_link }}">
                                    <img src="{{ asset($homepage->blog_banner_two) }}" alt="thumb">
                                </a>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Details part end -->

        <!-- mobile app  part start -->
        @include('frontend.layouts.partials.mobile_app')
        <!-- mobile app  part end -->


    </main>
@endsection



@push('js_section')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endpush
