<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}" target="_self">
            <img src="{{ asset('images/logo_pbj1.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">JOHOR BA</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link active" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-speedometer2"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>
    {{-- Modul Atlet - hanya untuk admin atau coach --}}
    @hasanyrole('admin|coach|athlete')
    <li class="nav-item">
        <a href="{{ route('athlete.index') }}" class="nav-link" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-person-walking"></i>
            </div>
            <span class="nav-link-text ms-1">Athlete</span>
        </a>
    </li>
    @endhasanyrole
    <li class="nav-item">
        <a href="{{ route('coach.index') }}" class="nav-link" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-person-badge"></i>
            </div>
            <span class="nav-link-text ms-1">Coach</span>
        </a>
    </li>
     @hasanyrole('admin|coach|club')
    <li class="nav-item">
        <a href="{{ route('clubs.index') }}" class="nav-link" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-people"></i>
            </div>
            <span class="nav-link-text ms-1">Club</span>
        </a>
    </li>
    @endhasanyrole
    {{-- Modul users - hanya untuk admin --}}
    @role('admin')
    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="nav-link" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-person"></i>
            </div>
            <span class="nav-link-text ms-1">User</span>
        </a>
    </li>
    @endrole
    {{-- Modul school - hanya untuk admin --}}
    @role('admin')
    <li class="nav-item">
        <a href="{{ route('school.index') }}" class="nav-link" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-building"></i>
            </div>
            <span class="nav-link-text ms-1">School</span>
        </a>
    </li>
    @endrole
    {{-- Modul achievement - hanya untuk admin --}}
    @role('admin')
    <li class="nav-item">
        <a href="{{ route('achievement.index') }}" class="nav-link" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-trophy"></i>
            </div>
            <span class="nav-link-text ms-1">Achievement</span>
        </a>
    </li>
    @endrole
    <li class="nav-item">
        <a href="{{ route('sanction.index') }}" class="nav-link" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-file-ruled"></i>
            </div>
            <span class="nav-link-text ms-1">Sanction</span>
        </a>
    </li>
    {{--
        <li class="nav-item">
        <a href="{{ route('setting.index') }}" class="nav-link" role="button">
            <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center me-2">
                <i class="bi bi-gear"></i>
            </div>
            <span class="nav-link-text ms-1">Setting</span>
        </a>
    </li>
</ul>

        {{-- <ul class="navbar-nav">
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link  "
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <div
                        class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <i class="ni ni-compass-04" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboards</span>
                </a>
                <div class="collapse  show " id="dashboardsExamples">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item  ">
                            <a class="nav-link  " href="../../pages/dashboards/default.html">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Default </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/dashboards/automotive.html">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal"> Automotive </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/dashboards/smart-home.html">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal"> Smart Home </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false" href="#vrExamples">
                                <span class="sidenav-mini-icon"> V </span>
                                <span class="sidenav-normal"> Virtual Reality <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="vrExamples">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/dashboards/vr/vr-default.html">
                                            <span class="sidenav-mini-icon text-xs"> V </span>
                                            <span class="sidenav-normal"> VR Default </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/dashboards/vr/vr-info.html">
                                            <span class="sidenav-mini-icon text-xs"> V </span>
                                            <span class="sidenav-normal"> VR Info </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/dashboards/crm.html">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal"> CRM </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">PAGES</h6>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#pagesExamples" class="nav-link " aria-controls="pagesExamples"
                    role="button" aria-expanded="false">
                    <div
                        class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>office</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g id="office" transform="translate(153.000000, 2.000000)">
                                            <path class="color-background"
                                                d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"
                                                opacity="0.6"></path>
                                            <path class="color-background"
                                                d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Pages</span>
                </a>
                <div class="collapse " id="pagesExamples">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/pages/pricing-page.html">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal"> Pricing Page </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/pages/rtl-page.html">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal"> RTL </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/pages/widgets.html">
                                <span class="sidenav-mini-icon"> W </span>
                                <span class="sidenav-normal"> Widgets </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/pages/charts.html">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal"> Charts </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/pages/sweet-alerts.html">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal"> Sweet Alerts </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/pages/notifications.html">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal"> Notifications </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#accountExample" class="nav-link " aria-controls="accountExample"
                    role="button" aria-expanded="false">
                    <div
                        class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <i class="ni ni-circle-08" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Account</span>
                </a>
                <div class="collapse " id="accountExample">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/account/settings.html">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal"> Settings </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/account/billing.html">
                                <span class="sidenav-mini-icon"> B </span>
                                <span class="sidenav-normal"> Billing </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/account/invoice.html">
                                <span class="sidenav-mini-icon"> I </span>
                                <span class="sidenav-normal"> Invoice </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/account/security.html">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal"> Security </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#applicationsExamples" class="nav-link "
                    aria-controls="applicationsExamples" role="button" aria-expanded="false">
                    <div
                        class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <svg width="12px" height="12px" viewBox="0 0 40 40" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>settings</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(304.000000, 151.000000)">
                                            <polygon class="color-background" opacity="0.596981957"
                                                points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667">
                                            </polygon>
                                            <path class="color-background"
                                                d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z"
                                                opacity="0.596981957"></path>
                                            <path class="color-background"
                                                d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Applications</span>
                </a>
                <div class="collapse " id="applicationsExamples">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/applications/kanban.html">
                                <span class="sidenav-mini-icon"> K </span>
                                <span class="sidenav-normal"> Kanban </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/applications/wizard.html">
                                <span class="sidenav-mini-icon"> W </span>
                                <span class="sidenav-normal"> Wizard </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/applications/datatables.html">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> DataTables </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/applications/calendar.html">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal"> Calendar </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/applications/analytics.html">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal"> Analytics </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#ecommerceExamples" class="nav-link "
                    aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                    <div
                        class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <svg class="text-dark" width="12px" height="12px" viewBox="0 0 42 44" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>basket</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1869.000000, -741.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g id="basket" transform="translate(153.000000, 450.000000)">
                                            <path class="color-background"
                                                d="M34.080375,13.125 L27.3748125,1.9490625 C27.1377583,1.53795093 26.6972449,1.28682264 26.222716,1.29218729 C25.748187,1.29772591 25.3135593,1.55890827 25.0860125,1.97535742 C24.8584658,2.39180657 24.8734447,2.89865282 25.1251875,3.3009375 L31.019625,13.125 L10.980375,13.125 L16.8748125,3.3009375 C17.1265553,2.89865282 17.1415342,2.39180657 16.9139875,1.97535742 C16.6864407,1.55890827 16.251813,1.29772591 15.777284,1.29218729 C15.3027551,1.28682264 14.8622417,1.53795093 14.6251875,1.9490625 L7.919625,13.125 L0,13.125 L0,18.375 L42,18.375 L42,13.125 L34.080375,13.125 Z"
                                                opacity="0.595377604"></path>
                                            <path class="color-background"
                                                d="M3.9375,21 L3.9375,38.0625 C3.9375,40.9619949 6.28800506,43.3125 9.1875,43.3125 L32.8125,43.3125 C35.7119949,43.3125 38.0625,40.9619949 38.0625,38.0625 L38.0625,21 L3.9375,21 Z M14.4375,36.75 L11.8125,36.75 L11.8125,26.25 L14.4375,26.25 L14.4375,36.75 Z M22.3125,36.75 L19.6875,36.75 L19.6875,26.25 L22.3125,26.25 L22.3125,36.75 Z M30.1875,36.75 L27.5625,36.75 L27.5625,26.25 L30.1875,26.25 L30.1875,36.75 Z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Ecommerce</span>
                </a>
                <div class="collapse " id="ecommerceExamples">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/ecommerce/overview.html">
                                <span class="sidenav-mini-icon"> O </span>
                                <span class="sidenav-normal"> Overview </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false"
                                href="#productsExample">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal"> Products <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="productsExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/ecommerce/products/new-product.html">
                                            <span class="sidenav-mini-icon text-xs"> N </span>
                                            <span class="sidenav-normal"> New Product </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/ecommerce/products/edit-product.html">
                                            <span class="sidenav-mini-icon text-xs"> E </span>
                                            <span class="sidenav-normal"> Edit Product </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/ecommerce/products/product-page.html">
                                            <span class="sidenav-mini-icon text-xs"> P </span>
                                            <span class="sidenav-normal"> Product Page </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/ecommerce/products/products-list.html">
                                            <span class="sidenav-mini-icon text-xs"> P </span>
                                            <span class="sidenav-normal"> Products List </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false"
                                href="#ordersExample">
                                <span class="sidenav-mini-icon"> O </span>
                                <span class="sidenav-normal"> Orders <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="ordersExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/ecommerce/orders/list.html">
                                            <span class="sidenav-mini-icon text-xs"> O </span>
                                            <span class="sidenav-normal"> Order List </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/ecommerce/orders/details.html">
                                            <span class="sidenav-mini-icon text-xs"> O </span>
                                            <span class="sidenav-normal"> Order Details </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/ecommerce/referral.html">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal"> Referral </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#projectsExample" class="nav-link "
                    aria-controls="projectsExample" role="button" aria-expanded="false">
                    <div
                        class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <i class="ni ni-delivery-fast" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Projects</span>
                </a>
                <div class="collapse " id="projectsExample">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/projects/general.html">
                                <span class="sidenav-mini-icon"> G </span>
                                <span class="sidenav-normal"> General </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/projects/new-project.html">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal"> New Project </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/projects/timeline.html">
                                <span class="sidenav-mini-icon"> T </span>
                                <span class="sidenav-normal"> Timeline </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#usersExample" class="nav-link " aria-controls="usersExample"
                    role="button" aria-expanded="false">
                    <div
                        class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <i class="ni ni-archive-2" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Team</span>
                </a>
                <div class="collapse " id="usersExample">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/team/projects.html">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal"> All Projects </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/team/messages.html">
                                <span class="sidenav-mini-icon"> M </span>
                                <span class="sidenav-normal"> Messages </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/team/new-user.html">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal"> New User </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/team/overview.html">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal"> Profile Overview </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/team/reports.html">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal"> Reports </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="../../pages/team/teams.html">
                                <span class="sidenav-mini-icon"> T </span>
                                <span class="sidenav-normal"> Teams </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#authExamples" class="nav-link " aria-controls="authExamples"
                    role="button" aria-expanded="false">
                    <div
                        class="icon icon-sm shadow-sm border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <svg width="12px" height="12px" viewBox="0 0 40 44" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>document</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(154.000000, 300.000000)">
                                            <path class="color-background"
                                                d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                                opacity="0.603585379"></path>
                                            <path class="color-background"
                                                d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Authentication</span>
                </a>
                <div class="collapse " id="authExamples">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false"
                                href="#signinExample">
                                <span class="sidenav-mini-icon"> SXXX </span>
                                <span class="sidenav-normal"> Sign In X <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="signinExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/signin/basic.html">
                                            <span class="sidenav-mini-icon text-xs"> B </span>
                                            <span class="sidenav-normal"> Basic </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/signin/cover.html">
                                            <span class="sidenav-mini-icon text-xs"> C </span>
                                            <span class="sidenav-normal"> Cover </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link "
                                            href="../../pages/authentication/signin/illustration.html">
                                            <span class="sidenav-mini-icon text-xs"> I </span>
                                            <span class="sidenav-normal"> Illustration </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false"
                                href="#signupExample">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal"> Sign Up <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="signupExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/signup/basic.html">
                                            <span class="sidenav-mini-icon text-xs"> B </span>
                                            <span class="sidenav-normal"> Basic </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/signup/cover.html">
                                            <span class="sidenav-mini-icon text-xs"> C </span>
                                            <span class="sidenav-normal"> Cover </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link "
                                            href="../../pages/authentication/signup/illustration.html">
                                            <span class="sidenav-mini-icon text-xs"> I </span>
                                            <span class="sidenav-normal"> Illustration </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false"
                                href="#resetExample">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal"> Reset Password <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="resetExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/reset/basic.html">
                                            <span class="sidenav-mini-icon text-xs"> B </span>
                                            <span class="sidenav-normal"> Basic </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/reset/cover.html">
                                            <span class="sidenav-mini-icon text-xs"> C </span>
                                            <span class="sidenav-normal"> Cover </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link "
                                            href="../../pages/authentication/reset/illustration.html">
                                            <span class="sidenav-mini-icon text-xs"> I </span>
                                            <span class="sidenav-normal"> Illustration </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false"
                                href="#lockExample">
                                <span class="sidenav-mini-icon"> L </span>
                                <span class="sidenav-normal"> Lock <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="lockExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/lock/basic.html">
                                            <span class="sidenav-mini-icon text-xs"> B </span>
                                            <span class="sidenav-normal"> Basic </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/lock/cover.html">
                                            <span class="sidenav-mini-icon text-xs"> C </span>
                                            <span class="sidenav-normal"> Cover </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/lock/illustration.html">
                                            <span class="sidenav-mini-icon text-xs"> I </span>
                                            <span class="sidenav-normal"> Illustration </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false"
                                href="#StepExample">
                                <span class="sidenav-mini-icon"> 2 </span>
                                <span class="sidenav-normal"> 2-Step Verification <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="StepExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link "
                                            href="../../pages/authentication/verification/basic.html">
                                            <span class="sidenav-mini-icon text-xs"> B </span>
                                            <span class="sidenav-normal"> Basic </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link "
                                            href="../../pages/authentication/verification/cover.html">
                                            <span class="sidenav-mini-icon text-xs"> C </span>
                                            <span class="sidenav-normal"> Cover </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link "
                                            href="../../pages/authentication/verification/illustration.html">
                                            <span class="sidenav-mini-icon text-xs"> I </span>
                                            <span class="sidenav-normal"> Illustration </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " data-bs-toggle="collapse" aria-expanded="false"
                                href="#errorExample">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal"> Error <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="errorExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/error/404.html">
                                            <span class="sidenav-mini-icon text-xs"> E </span>
                                            <span class="sidenav-normal"> Error 404 </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="../../pages/authentication/error/500.html">
                                            <span class="sidenav-mini-icon text-xs"> E </span>
                                            <span class="sidenav-normal"> Error 500 </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        </ul> --}}
    </div>
</aside>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">