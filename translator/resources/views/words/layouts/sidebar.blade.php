<section class="side-bar">
    <div class="mobile-nav-menu">
        <h2 class="mobile-nav-menu__title">{{ __('Memorize words') }}</h2>
        <ul class="mobile-nav-menu__items">
            <li class="mobile-nav-menu__item">
                <a href="{{ route('random') }}"
                    class="mobile-nav-menu__link mobile-nav-menu__link--active">{{ __('Random') }}</a>
            </li>
            <li class="mobile-nav-menu__item">
                <a href="{{ route('leitner') }}" class="mobile-nav-menu__link">{{ __('Leitner Box') }}</a>
            </li>
        </ul>

    </div>

    <div class="mobile-nav__btn">
        <span class="mobile-nav__btn-line"></span>
    </div>
</section>
