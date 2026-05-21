@php
    $homepage = Modules\Page\App\Models\Homepage::first();
@endphp
<section class="footer">
    <div class="container">

        <div class="row">
            <div class="col-xxl-12">
                <div class="footer_top_circle_ani"></div>
                <div class="footer_top_circle_ani two"></div>
                <div class="footer_top_circle_ani three"></div>
                <div class="footer_top_circle_ani four"></div>
            </div>
        </div>


        <div class="row">
            <div class="col-xxl-3 col-xl-3" data-aos="fade-right" data-aos-delay="100">

                <a href="{{route('home')}}" class="footer_logo">
                    <img src="{{asset($general_setting->footer_logo)}}" alt="logo">
                </a>

                <div class="footer_txt">
                    <p>{{ html_decode($footer->about_us) }} </p>
                </div>

                <ul class="footer_social_icon">
                    <li>
                        <a href="{{ $footer->facebook }}" target="_blank">
                                <span>
                                    <svg width="11" height="16" viewBox="0 0 11 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.6667 0H8.55556C5.79413 0 3.55556 2.23857 3.55556 5V6.22222H0V9.77778H3.55556V16H7.11111V9.77778H10.6667V6.22222H7.11111V4.55556C7.11111 4.00327 7.55883 3.55556 8.11111 3.55556H10.6667V0Z"/>
                                    </svg>

                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $footer->twitter }}" target="_blank">
                                <span>
                                    <svg width="19" height="17" viewBox="0 0 19 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.7642 0C10.5722 0 8.7953 1.86585 8.7953 4.1675C8.7953 4.5153 8.83587 4.85315 8.91232 5.17611C6.80469 5.17611 3.63013 4.74999 0.978868 2.09376C0.626315 1.74054 -0.0237835 1.9767 0.000670803 2.47516C0.393588 10.484 3.82353 12.8202 5.58986 12.9656C4.44926 14.0921 2.79242 14.9813 1.1252 15.3804C0.685191 15.4857 0.576494 15.9674 1.00675 16.1073C2.19973 16.4953 3.90729 16.6448 4.82642 16.67C11.3286 16.67 16.6134 11.1972 16.731 4.3991C17.5847 3.84394 18.1315 2.63855 18.4388 1.78464C18.5136 1.57667 18.1728 1.33436 17.9687 1.41931C17.331 1.68479 16.5214 1.74773 15.8318 1.52302C15.1039 0.593104 14 0 12.7642 0Z"/>
                                    </svg>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $footer->instagram }}" target="_blank">
                                <span>
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5 0C2.23858 0 0 2.23858 0 5V11.33C0 14.0914 2.23858 16.33 5 16.33H11.33C14.0914 16.33 16.33 14.0914 16.33 11.33V5C16.33 2.23858 14.0914 0 11.33 0H5ZM13.0645 4.08222C13.5155 4.08222 13.881 3.71666 13.881 3.26572C13.881 2.81478 13.5155 2.44922 13.0645 2.44922C12.6136 2.44922 12.248 2.81478 12.248 3.26572C12.248 3.71666 12.6136 4.08222 13.0645 4.08222ZM12.247 8.16551C12.247 10.4202 10.4192 12.248 8.16453 12.248C5.90983 12.248 4.08203 10.4202 4.08203 8.16551C4.08203 5.91081 5.90983 4.08301 8.16453 4.08301C10.4192 4.08301 12.247 5.91081 12.247 8.16551ZM8.16434 10.6138C9.51717 10.6138 10.6138 9.51717 10.6138 8.16434C10.6138 6.81152 9.51717 5.71484 8.16434 5.71484C6.81152 5.71484 5.71484 6.81152 5.71484 8.16434C5.71484 9.51717 6.81152 10.6138 8.16434 10.6138Z"/>
                                    </svg>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $footer->linkedin }}" target="_blank">
                            <span>
                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2ZM4 6.5V20H0V6.5H4ZM7 6.5H11V7.34141C11.6256 7.12031 12.2987 7 13 7C16.3137 7 19 9.68629 19 13V20H15V13C15 11.8954 14.1046 11 13 11C11.8954 11 11 11.8954 11 13V20H7V13V6.5Z" />
                                    </svg>


                            </span>

                        </a>
                    </li>
                </ul>

            </div>


            <div class="col-xxl-9 col-xl-9">
                <div class="row footer_ml">
                    <div class="col-xxl-4 col-sm-6  col-lg-4 " data-aos="fade-up" data-aos-delay="200">
                        <div class="footer_txt_item">
                            <h5>{{__('translate.Popular links')}}</h5>
                        </div>


                        <ul class="footer_link">
                            @include('menu::components.footer-menu', ['location' => 'footer'])
                        </ul>


                    </div>


                    <div class="col-xxl-4 col-sm-6 col-lg-4 mr_mt_25px photo_gallery_ml" data-aos="fade-up"
                         data-aos-delay="300">
                        <div class="footer_txt_item">
                            <h5>{{__('translate.Photo Gallery')}}</h5>
                        </div>

                        <div class="footer_photo_gallery_item">
                            <div class="footer_photo_gallery_inner">
                                <a target="_blank" href="{{ $homepage->footer_img_one_link }}" class="footer_photo_gallery_thumb">
                                    <img src="{{asset($homepage->footer_img_one)}}" alt="footer_gallery_one">
                                </a>
                                <a target="_blank" href="{{ $homepage->footer_img_two_link }}" class="footer_photo_gallery_thumb">
                                    <img src="{{asset($homepage->footer_img_two)}}" alt="footer_gallery_two">
                                </a>
                                <a target="_blank" href="{{ $homepage->footer_img_three_link }}" class="footer_photo_gallery_thumb">
                                    <img src="{{asset($homepage->footer_img_three)}}" alt="footer_gallery_three">
                                </a>
                            </div>
                            <div class="footer_photo_gallery_inner two">
                                <a target="_blank" href="{{ $homepage->footer_img_four_link }}" class="footer_photo_gallery_thumb">
                                    <img src="{{asset($homepage->footer_img_four)}}"
                                         alt="footer_gallery_four">
                                </a>
                                <a target="_blank" href="{{ $homepage->footer_img_five_link }}" class="footer_photo_gallery_thumb">
                                    <img src="{{asset($homepage->footer_img_five)}}"
                                         alt="footer_gallery_four">
                                </a>
                                <a target="_blank" href="{{ $homepage->footer_img_six_link }}" class="footer_photo_gallery_thumb">
                                    <img src="{{asset($homepage->footer_img_six)}}"
                                         alt="footer_gallery_four">
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="col-xxl-4 col-lg-4  mr_mt_35px" data-aos="fade-up" data-aos-delay="400">
                        <div class="footer_txt_item">
                            <h5>{{__('translate.Newsletter')}}</h5>
                        </div>

                        <form action="{{ route('newsletter-request') }}" method="post" class="footer_newsletter_form">
                            @csrf
                            <div class="footer_newsletter_form_item">
                                <label for="newsletter_email" class="form-label">{{__('translate.Subscribe newsletter to get updates')}}</label>
                                <div class="footer_newsletter_form_inner">
                                    <input type="email" class="form-control" id="search_input_2"
                                           placeholder="{{ __('translate.Email Address') }}" name="email">
                                    <button type="submit" class="thm-btn">{{__('translate.Subscribe')}}</button>
                                </div>
                            </div>
                        </form>


                        <div class="footer_payment">
                            <div class="footer_payment_txt">
                                <h5>{{__('translate.We accept Payment methods')}}:</h5>
                            </div>

                            <div class="footer_payment_thumb ">
                               <img src="{{ asset($footer->payment_image) }}" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-xxl-6 col-sm-6 col-md-7">
                    <div class="copyright_left_txt">
                       <a href="javascript:;"><span>{{ $footer->copyright }}</span></a>
                    </div>
                </div>
                <div class="col-xxl-6 col-sm-6 col-md-5">
                    <ul class="copyright_rigth_txt">
                        <li>
                            <a href="{{route('privacy.policy')}}">{{__('translate.Privacy Policy')}}</a>
                        </li>
                        <li>
                            <a href="{{route('terms.and.conditions')}}"> {{__('translate.Terms & Conditions')}}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col_xxl-12">
                    <!-- back_to_top start  -->
                    <a href="#top" class="back_to_top">
                            <span>
                                <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5 1.09375L13.5938 7.15625C13.875 7.46875 13.875 7.9375 13.5938 8.21875L12.875 8.9375C12.5938 9.21875 12.125 9.21875 11.8125 8.9375L7 4.125L2.15625 8.9375C1.84375 9.21875 1.375 9.21875 1.09375 8.9375L0.375 8.21875C0.09375 7.9375 0.09375 7.46875 0.375 7.15625L6.46875 1.09375C6.75 0.8125 7.21875 0.8125 7.5 1.09375Z"/>
                                </svg>

                            </span>
                    </a>
                    <!-- back_to_top end -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- footer part end -->
