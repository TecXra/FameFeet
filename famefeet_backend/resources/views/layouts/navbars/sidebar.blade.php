<div class="sidebar" style="overflow: auto">
    <div class="sidebar-wrapper min-vh-100">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-normal">
                <i class="tim-icons icon-world" style="margin-right: 5px"></i>
                {{ __('FameFeet Dashboard') }}
            </a>
        </div>
        <ul class="nav vh-100">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'myEarnings') class="active " @endif>
                <a href="{{ route('admin.earnings.all') }}">
                    <i class="tim-icons icon-components"></i>
                    <p>{{ __('My Earnings') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'allWithdrawRequests') class="active " @endif>
                <a href="{{ route('admin.withdrawal_requests') }}">
                    <i class="tim-icons icon-components"></i>
                    <p>{{ __('Withdrawal Requests') }}</p>
                </a>
            </li>

            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <span class="nav-link-text" >{{ __('Manage Users') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'user') class="active " @endif>
                            <a href="{{ route('user.getAllUser') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'celebrity') class="active " @endif>
                            <a href="{{ route('celebrity.all') }}">
                                {{-- <i class="tim-icons icon-image-02"></i> --}}
                                <i >
                                    <img src="{{ asset('black/img/female-user-svgrepo-com.png') }}" alt="" height="20px" width="20px">
                                </i>
                                {{-- <i>

                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-heart" viewBox="0 0 16 16">
                                    <path d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/>
                                </svg></i> --}}
                                <p>{{ __('Celebrity') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'fan') class="active " @endif>
                            <a href="{{ route('fan.all') }}">
                                {{-- <i class="tim-icons icon-user-run"></i> --}}
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-hearts" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.5 1.246c.832-.855 2.913.642 0 2.566-2.913-1.924-.832-3.421 0-2.566ZM9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276ZM15 2.165c.555-.57 1.942.428 0 1.711-1.942-1.283-.555-2.281 0-1.71Z"/>
                                    </svg>
                                </i>
                                <p>{{ __('Fan') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

{{--            Transactions--}}
            <li>
                <a data-toggle="collapse" href="#transactions_log" aria-expanded="true">
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <span class="nav-link-text" >{{ __('All Transactions') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="transactions_log">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'allIncomingPlatform') class="active " @endif>
                            <a href="{{ route('admin.incoming') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User TopUps') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'allOutgoingPlatform') class="active " @endif>
                            <a href="{{ route('admin.outgoing') }}">
                                {{-- <i class="tim-icons icon-image-02"></i> --}}
                                <i >
                                    <img src="{{ asset('black/img/female-user-svgrepo-com.png') }}" alt="" height="20px" width="20px">
                                </i>
                                {{-- <i>

                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-heart" viewBox="0 0 16 16">
                                    <path d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/>
                                </svg></i> --}}
                                <p>{{ __('User Withdrawals') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'allPlatform') class="active " @endif>
                            <a href="{{ route('admin.all') }}">
                                {{-- <i class="tim-icons icon-user-run"></i> --}}
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-hearts" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.5 1.246c.832-.855 2.913.642 0 2.566-2.913-1.924-.832-3.421 0-2.566ZM9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276ZM15 2.165c.555-.57 1.942.428 0 1.711-1.942-1.283-.555-2.281 0-1.71Z"/>
                                    </svg>
                                </i>
                                <p>{{ __('All Transactions') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>




            <li @if ($pageSlug == 'categories') class="active " @endif>
                <a href="{{ route('category.all') }}">
                    <i class="tim-icons icon-components"></i>
                    <p>{{ __('Categories') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'feetSize') class="active" @endif>
                <a href="{{ route('feet.all') }}">
                    {{-- <i class="tim-icons icon-atom"></i> --}}
                    <i >
                        <img src="{{ asset('black/img/tiptoe-feet-outline-svgrepo-com.png') }}" alt="" height="24px" width="24px">
                    </i>
                    <p>{{ __('Feet Sizes') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'socksSize') class="active" @endif>
                <a href="{{ route('socks.all') }}">
                    <i >
                        <img src="{{ asset('black/img/pair-of-socks-svgrepo-com.png') }}" alt="" height="24px" width="24px">
                    </i>

                    <p>{{ __('socks Sizes') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'transaction') class="active" @endif>
                <a href="{{ route('all.transactions') }}">
                    <i class="mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                            <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                            <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                          </svg>
                    </i>
                    <p>{{ __('All Transactions') }}</p>
                </a>
            </li>
          {{-- <li @if ($pageSlug == 'post') class="active" @endif>
                <a href="{{ route('post.all') }}">
                    <i class="tim-icons icon-camera-18"></i>
                    <p>{{ __('Posts') }}</p>
                </a>
            </li> --}}
            {{-- <li @if ($pageSlug == 'offer') class="active " @endif>
                <a href="{{ route('offer.all') }}">
                    <i class="tim-icons icon-tag"></i>
                    <p>{{ __('Offers') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'shop') class="active " @endif>
                <a href="{{ route('shop.all') }}">
                    <i class="tim-icons icon-cart"></i>
                    <p>{{ __('Shops') }}</p>
                </a>
            </li> --}}
            {{-- <li @if ($pageSlug == 'order') class="active " @endif>
                <a href="{{ route('order.all') }}">
                    <i class="tim-icons icon-delivery-fast"></i>
                    <p>{{ __('Orders') }}</p>
                </a>
            </li> --}}
            <li @if ($pageSlug == 'testimonials') class="active " @endif>
                <a href="{{ route('all.testimonial') }}">
                    {{-- <i class="tim-icons icon-coins"></i> --}}
                    <svg class="ml-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-text" viewBox="0 0 16 16">
                        <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                        <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8zm0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                      </svg>
                    <span>{{ __('Testimonials') }}</span>
                </a>
            </li>
            <li @if ($pageSlug == 'horizone') class="active " @endif>
                <a href="{{ url('/horizon/dashboard') }}">

                    <i >
                        <img src="{{ asset('black/img/laravel-horizon-svgrepo-com.png') }}" alt="" height="16px" width="16px">
                    </i>
                    <span>{{ __('Horizon Dashboard') }}</span>
                </a>
            </li>
            {{-- <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li> --}}
        </ul>
    </div>
</div>

