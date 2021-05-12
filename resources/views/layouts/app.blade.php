<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/css/fontawesome.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/adminlte.css" />
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    @yield('stylesheet')
    <style>
        body {
            font-family: 'Oswald', sans-serif;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <form id='logout' method="post" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <a class="nav-link" href="javascript:{}"
                        onclick="document.getElementById('logout').submit();">Logout</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <div id="notifications">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" @click="clearNum()">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">@{{ number }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="height: auto;
        max-height: 500px;
        overflow-x: hidden;">
                            <span class="dropdown-item dropdown-header">Recent
                                Notifications</span>
                            <div class="dropdown-divider"></div>
                            <div v-for="notification in notifications">
                                <a class="dropdown-item" :href="notification.data.link">
                                    <i class="fas mr-2"
                                        :class="getClass(notification.data.type)"></i>@{{ notification.data.message }}
                                    <span class="float-right text-muted text-sm">@{{ notification.created_at }}</span>
                                </a>
                                <br>
                                <div class="dropdown-divider"></div>
                            </div>
                            <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">See All
                                Notifications</a>
                        </div>
                    </li>
                </div>

            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a style="pointer-events: none; cursor: default;" class="brand-link">
                <img src="/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: 0.8" />
                <span class="brand-text font-weight-bolder">La Posta</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/storage/{{ auth()->user()->avatar ?? 'profile/default.png' }} "
                            class="img-circle elevation-2" alt="User Image" />
                    </div>
                    <div class="info">
                        <a href="{{ route('profile.index') }}" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('posts.create') }}"
                                class="nav-link {{ request()->is('posts/create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>New Post</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('posts.index_queued') }}"
                                class="nav-link {{ request()->is('posts/queued') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Queued Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('posts.index_drafted') }}"
                                class="nav-link {{ request()->is('posts/drafted') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>Drafted Posts</p>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="{{ route('media.index') }}"
                                class="nav-link {{ request()->is('media') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-photo-video"></i>
                                <p>Media</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index') }}"
                                class="nav-link {{ request()->is('accounts') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Accounts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('calendar') }}"
                                class="nav-link {{ request()->is('calendar') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Calendar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile.index') }}"
                                class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        @yield('content')

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="{{ route('dashboard') }}">La Posta.io</a>.</strong>
            All rights reserved.
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="/js/jquery.js"></script>
    <!-- Bootstrap -->
    <script src="/js/bootstrap.js"></script>
    <!-- AdminLTE App -->
    <script src="/js/adminlte.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script>
        const app1 = new Vue({
    el: '#notifications',
    data: {
        notifications: @json($notifications),
        number: ""
    },
    computed: {
        num: function() {
            return (parseInt(this.number) || 0)
        }
    },
    methods: {
        clearNum: function() {
            this.number = ""
        },
        getClass: function(type) {
            let classes = {
                login: "fa-exclamation-triangle ",
                post: "fa-envelope"
            }
            return classes[type]
        }
    },
    created() {
        Echo.private('users.' + {{auth()->user()->id}}).notification((e) => {
                $(document).Toasts('create', {
                    class: 'bg-' + e.status,
                    title: e.type+' alert',
                    body: e.message
                })
                this.number = this.num + 1
                this.notifications.unshift({
                    data: e,
                    created_at: 'just now'
                })
            })
    }
})
    </script>
    @yield('script')
</body>

</html>