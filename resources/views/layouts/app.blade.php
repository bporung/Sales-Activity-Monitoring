<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sales Activity Monitoring System') }}</title>

        <link rel="stylesheet" href="{{ asset('css/fontawesome/5-15-1/css/all.css') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        
    </head>
    <body class="font-sans antialiased max-h-screen bg-gray-100 overflow-hidden">
        
        <div class="panelWrapper" x-data="{openNavigation : true}" >
            <!-- NAVIGATION -->
            <div class="panelNavigation"  x-cloak  x-bind:class="openNavigation ? 'navigationTrue' : 'navigationFalse'">
                <div class="flex flex-col h-screen">
                    <div class="my-5 "><h5 class="font-semibold text-xl text-center">Sales Activity</h5></div>
                    <div class="mb-5 ">
                        <div class="">
                            <ul>
                                <li class="py-3"><span class="px-2 text-gray-500">Welcome, {{Auth::user()->name}}</span></li>
                                <li class="py-2"><a href="/notification" class="px-5">Notification @livewire('component.websocket.notificationbadge')</a></li>
                                <li class="py-2"><a href="/profile/editpassword" class="px-5">Change Password</a></li>
                                <li class="py-2"><a href="/profile" class="px-5">Profile</a></li>
                                <li class="py-2 px-5">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button><i class="fas fa-sign-out-alt"></i><span>Log Out</span></button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="navigationScroll flex-grow overflow-hidden hover:overflow-y-auto">
                        <div class="">
                            <ul>
                                <li class="py-3"><span class="px-2 text-gray-500">Navigation</span></li>
                                <li class="py-2"><a href="/dashboard" class="px-5">Dashboard</a></li>
                                @canany(['read all user','read self user'])
                                <li class="py-2"><a href="/user" class="px-5">User</a></li>
                                @endcanany
                            </ul>
                        </div>
                        <div class="">
                            <ul>
                                <li class="py-3"><span class="px-2 text-gray-500">Apps</span></li>
                                @canany(['read all customer','read self customer'])
                                <li class="py-2"><a href="/customer" class="px-5">Customer</a></li>
                                @endcanany
                                @canany(['read all item','read self item'])
                                <li class="py-2"><a href="/item" class="px-5">Item</a></li>
                                @endcanany
                                @canany(['read all interaction','read self interaction'])
                                <li class="py-2"><a href="/interaction" class="px-5">Interaction</a></li>
                                @endcanany
                            </ul>
                        </div>
                        <div class="">
                            <ul>
                                <li class="py-3"><span class="px-2 text-gray-500">Report</span></li>
                                @canany(['read all user','read self user'])
                                <li class="py-2"><a href="/report/user/performances" class="px-5">User Performance</a></li>
                                @endcanany
                            </ul>
                        </div>
                        <!-- <div class="">
                            <ul>
                                <li class="py-3"><span class="px-2 text-gray-500">Map</span></li>
                                @canany(['read all interaction','read self interaction'])
                                <li class="py-2"><a href="/map/interaction?q=all" class="px-5">Interaction</a></li>
                                @endcanany
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- END OF NAVIGATION -->

            <div class="panelContent"  x-cloak >
                <div class="panelContentWrapper">
                    <!-- HEADER -->
                    <div class="mainHeader">
                        <div class="flex items-center">
                            <button type="button" @click="openNavigation = !openNavigation"><i class="fas fa-bars text-xl"></i></button>
                            <div class="mx-2">
                                @if(isset($pagetitle) && $pagetitle)
                                    @php $i=1; @endphp
                                    @foreach($pagetitle as $pt)
                                        @if($pt['link'])
                                            <a class="hover:text-blue-500 hover:border-b hover:border-blue-500 transition-all" href="{{$pt['link']}}">{!! $pt['title'] !!}</a>
                                        @else
                                            <a>{!! $pt['title'] !!}</a>
                                        @endif
                                        @if(count($pagetitle) > $i)
                                            <span class="mx-1">/</span>
                                        @endif
                                        @php $i++; @endphp
                                    @endforeach
                                @else
                                    <a>Title Undefined</a>
                                @endif
                            </div>
                        </div>
                        @if(isset($navigationTab))
                        <div class="grid grid-cols-1 mt-2 sm:mt-5">
                            <div class="">
                                @foreach($navigationTab as $navTab)
                                    @if(!isset($navTab['visibility']) || $navTab['visibility'])
                                    <a href="{{$navTab['status'] ? '' : $navTab['link']}}" class="capitalize menuTab {{$navTab['status'] ? 'activeTab' : ''}}">{{$navTab['title']}}</a>
                                    @endif
                                @endforeach
                            </div>
                            <div>
                                @stack('header')
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- END OF HEADER -->
                    
                    <!-- CONTENT -->
                    <div class="mainContent" >
                        <div class="mainContentContainer">
                            <main>
                                {{ $slot }}
                            </main>
                        </div>
                    </div>
                    <!-- END OF CONTENT -->
                </div>
            </div>
        </div>

        @stack('modals')

        @stack('scripts')
        @livewireScripts
    </body>
</html>
