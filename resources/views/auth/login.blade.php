<!DOCTYPE html>
<html lang="en">
<head>
    @meta_tags('head')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.19/dist/css/uikit.min.css" />

    <!-- Scripts -->
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.19/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.19/dist/js/uikit-icons.min.js"></script>

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
        <!-- login -->
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form class="toggle-class" action="{{ route('login') }}" method="POST">
            @csrf
            <fieldset class="uk-fieldset">
                <div class="uk-margin-small">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: user"></span>
                        <input class="uk-input uk-border-pill" name="username"
                            placeholder="{{ __('Email or phone number') }}" type="text" value="{{ old('username') }}"
                            required autofocus />
                        @error('username')
                            <small class="uk-text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="uk-margin-small">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
                        <input class="uk-input uk-border-pill" name="password" placeholder="{{ __('Password') }}"
                            type="password" required autocomplete="current-password">
                        @error('password')
                            <small class="uk-text-danger">{{ $message }}</small>
                        @enderror

                    </div>
                </div>
                <div class="uk-margin-small">
                    <label><input class="uk-checkbox uk-margin-small-right" name="remember" type="checkbox"
                            @if (old('remember')) checked @endif>{{ __('Keep me logged in') }}</label>
                </div>
                <div class="uk-margin-bottom">
                    <button type="submit"
                        class="uk-button uk-button-primary uk-border-pill uk-width-1-1">{{ __('Login') }}</button>
                </div>
            </fieldset>
        </form>

        <div>
            @if (Route::has('password.request'))
                <div class="uk-text-center">
                    <a class="uk-link-reset uk-text-small toggle-class" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif

            @if (Route::has('register'))
                <div class="uk-text-center">

                    <a class="uk-link-reset uk-text-small toggle-class" href="{{ route('register') }}">
                        {{ __('No account yet? Register') }}
                    </a>
                </div>
            @endif
        </div>

        <div>
            <a href="#" class="uk-button uk-width-1-1 bg-facebook"><i class="uk-icon uk-margin-small-right" data-icon="facebook" uk-icon></i>{{ __('Login with Facebook') }}</a>
        </div>

        <style>
            .bg-facebook {
                background-color: #3b5998;
            }
            .uk-icon[data-icon="facebook"] {
                background: white;
                color: #2b5998;
                padding: 0.25em;
            }
        </style>
    </div>
    <!-- /login -->
    </div>
</body>
</html>