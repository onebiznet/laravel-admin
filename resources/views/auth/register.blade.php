<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.19/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Scripts -->
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.19/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.19/dist/js/uikit-icons.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js" integrity="sha512-+gShyB8GWoOiXNwOlBaYXdLTiZt10Iy6xjACGadpqMs20aJOoh+PJt3bwUVA6Cefe7yF7vblX6QwyXZiVwTWGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

    <style>
        /* Background Image Media Queries */
        body.login {
            background-image: url('https://picsum.photos/640/700/?image=1044');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        @media screen and (min-width: 640px) {
            body {
                background-image: url('https://picsum.photos/960/700/?image=1044');
            }
        }

        @media screen and (min-width: 960px) {
            body {
                background-image: url('https://picsum.photos/1200/900/?image=1044');
            }
        }

        @media screen and (min-width: 1200px) {
            body {
                background-image: url('https://picsum.photos/1600/950/?image=1044');
            }
        }

        @media screen and (min-width: 1600px) {
            body {
                background-image: url('https://picsum.photos/2000/1050/?image=1044');
            }
        }

        .iti { width: 100%; }
        .iti__country-list { background: rgba(34,34,34,.8); }
    </style>
</head>

<body
    class="uk-cover-container uk-background-secondary uk-flex uk-flex-center uk-flex-middle uk-height-viewport uk-overflow-auto uk-light"
    data-uk-height-viewport>
    <!-- overlay -->
    <div class="uk-position-cover uk-overlay-primary"></div>
    <!-- /overlay -->
    <div class="uk-position-bottom-center uk-position-small uk-visible@m uk-position-z-index">
        <span class="uk-text-small uk-text-muted">© 2019 Company Name - <a
                href="https://github.com/zzseba78/Kick-Off">Created by KickOff</a> | Built with <a
                href="http://getuikit.com" title="Visit UIkit 3 site" target="_blank" data-uk-tooltip><span
                    data-uk-icon="uikit"></span></a></span>
    </div>
    <div class="uk-width-medium uk-padding-small uk-position-z-index" uk-scrollspy="cls: uk-animation-fade">
        <form action="{{ route('register') }}" class="toggle-class" method="POST" x-data="{
            password: '{{ old('password') }}',
            password_confirmation: '{{ old('password_confirmation') }}'
        }">
            @csrf

            <fieldset class="uk-fieldset">
                <div class="uk-margin-small">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: user"></span>
                        <input type="text" class="uk-input uk-border-pill" name="name"
                            placeholder="{{ __('Full Name') }}" value="{{ old('name') }}" autofocus>
                    </div>
                    @error('name')
                        <small class="uk-text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="uk-margin-small">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: mail"></span>
                        <input type="text" class="uk-input uk-border-pill" name="email"
                            placeholder="{{ __('Email address') }}" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <small class="uk-text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="uk-margin-small">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: receiver"></span>
                        <x-admin::form.phone-input class="uk-input uk-border-pill" name="phone" value="{{ old('phone') }}"/>
                        {{-- <input type="text" class="uk-input uk-border-pill" name="phone"
                            placeholder="{{ __('Mobile number') }}" value="{{ old('phone') }}"> --}}
                    </div>
                    @error('phone')
                        <small class="uk-text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="uk-margin-small">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
                        <input type="password" class="uk-input uk-border-pill" name="password" x-model="password"
                            placeholder="{{ __('Password') }}" required autocomplete="new-password">
                    </div>
                    @error('password')
                        <small class="uk-text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="uk-margin-small">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip"
                            :class="(password_confirmation === '') ? 'uk-text-muted' : (password == password_confirmation ? 
                                'uk-text-success': 'uk-text-danger')"
                            data-uk-icon="icon: check"></span>
                        <input type="password" class="uk-input uk-border-pill" name="password_confirmation"
                            x-model="password_confirmation" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                    </div>
                    @error('password_confirmation')
                        <small class="uk-text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </fieldset>

            <div class="uk-margin-small">
                <label for="terms" class="@error('terms') uk-text-danger @enderror uk-width-1-1 uk-flex"><input
                        type="checkbox"
                        class="uk-checkbox uk-margin-small-right @error('terms') uk-text-danger @enderror"
                        id="terms" name="terms" @if (old('terms')) checked @endif>
                    <small>{!! __('I agree to the :terms_of_service and :privacy_policy', [
                        'terms_of_service' =>
                            '<a target="_blank" href="' .
                            //route('terms.show') .
                            '" class="text-sm text-gray-600 underline hover:text-gray-900">' .
                            __('Terms of Service') .
                            '</a>',
                        'privacy_policy' =>
                            '<a target="_blank" href="' .
                            //route('policy.show') .
                            '" class="text-sm text-gray-600 underline hover:text-gray-900">' .
                            __('Privacy Policy') .
                            '</a>',
                    ]) !!}</small>
                </label>
                @error('terms')
                    <small class="uk-text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="uk-margin-bottom">
                <button type="submit"
                    class="uk-button uk-button-primary uk-border-pill uk-width-1-1">{{ __('Register') }}</button>
            </div>

        </form>

        <div class="uk-text-center">
            {{ __('Already registered?') }}
            <a href="{{ route('login') }}" class=""> {{ __('Login') }}</a>
        </div>
        {{-- <script>
            const input = document.querySelector('input[name=phone]');
            const phone = intlTelInput(input, {
                initialCountry: 'MM',
                nationalMode: false,
                autoPlaceholder: 'aggressive',
                separateDialCode: true,
            });
        </script> --}}
    </div>
</body>

</html>
