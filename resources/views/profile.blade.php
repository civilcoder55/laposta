@extends('layouts.app')

@section('title', 'Profile')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="row">
                        <div class="col mt-3">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row justify-content-center">
                    <div class="col-sm-6 mt-5">
                        <div class="card">
                            <div class="card-header d-flex align-items-baseline">
                                <h3 class="card-title">Profile information</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input class="form-control @error('email') is-invalid @enderror" id="email"
                                            type="email" name="email"
                                            value="{{ old() ? old('email') : auth()->user()->email }}" placeholder="Email"
                                            aria-describedby="error">
                                        @error('email')
                                            <span id="error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                                            type="text" name="name"
                                            value="{{ old() ? old('name') : auth()->user()->name }}" placeholder="Name"
                                            aria-describedby="error">
                                        @error('name')
                                            <span id="error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Profile Avatar</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                    class="custom-file-input @error('avatar') is-invalid @enderror"
                                                    id="file" name="avatar" accept=".png, .jpg, .jpeg"
                                                    aria-describedby="error">
                                                <label class="custom-file-label" @error('avatar') style="color:#dc3545"
                                                    @enderror
                                                    for="file">{{ $errors->has('avatar') ? $errors->first('avatar') : 'Choose Avatar' }}</label>

                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-5">
                        <div class="card">
                            <div class="card-header d-flex align-items-baseline">
                                <h3 class="card-title">Change Password</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update.password') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="oldPassword">Password</label>
                                        <input class="form-control @error('oldPassword') is-invalid @enderror"
                                            id="oldPassword" type="password" name="oldPassword" placeholder="Old Password">
                                        @error('oldPassword')
                                            <span id="error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror" id="password"
                                            type="password" name="password" placeholder="New Password">
                                        @error('password')
                                            <span id="error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input class="form-control" id="password_confirmation" type="password"
                                            name="password_confirmation" placeholder="Confirm Password">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-5">
                        <div class="card">
                            <div class="card-header d-flex align-items-baseline">
                                <h3 class="card-title">Sessions</h3>
                            </div>
                            <div class="card-body">
                                <table id="sessionsTable" class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>IP</th>
                                            <th>Browser</th>
                                            <th>Last Activity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $current_session['ip_address'] }}</td>
                                            @php
                                                $agent = get_browser($current_session['user_agent'], true);
                                            @endphp
                                            <td>
                                                This session
                                            </td>
                                            <td>
                                                Active Now
                                            </td>
                                            <td style="text-align: center;">
                                                <a
                                                    href='{{ route('profile.session.destroy', [$current_session['pub_id']]) }}'><i
                                                        class="nav-icon fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        @foreach ($other_sessions as $session)
                                            <tr>
                                                <td>{{ $session['ip_address'] }}</td>
                                                @php
                                                    $agent = get_browser($session['user_agent'], true);
                                                @endphp
                                                <td>
                                                    {{ $agent['browser'] }} on {{ $agent['platform'] }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::now()->timestamp - $session['last_activity'] < 300 ? 'Active Now' : \Carbon\Carbon::createFromTimestamp($session['last_activity'])->diffForHumans() }}
                                                </td>
                                                <td style="text-align: center;">
                                                    <a
                                                        href='{{ route('profile.session.destroy', [$session['pub_id']]) }}'><i
                                                            class="nav-icon fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mt-5">
                        <div class="card">
                            <div class="card-header d-flex align-items-baseline">
                                <h3 class="card-title">Linked Social Accounts</h3>
                            </div>
                            @if ($user = auth()
            ->user()
            ->socialAuthUser()
            ->where(['provider' => 'facebook'])
            ->first())
                                <div class="form-group m-2">

                                    <button type="button" class="btn bg-gradient-primary btn-sm"
                                        onclick="location.href = '{{ route('revoke.facebook') }}';"><i
                                            class="fab fa-facebook-f pr-1"></i>{{ $user->uid }}
                                        Connected</button>

                                </div>
                            @else
                                <div class="form-group m-2">

                                    <button type="button" class="btn bg-gradient-primary btn-sm"
                                        onclick="location.href = '{{ route('login.social', 'facebook') }}';"><i
                                            class="fab fa-facebook-f pr-1"></i> login with facebook</button>

                                </div>
                            @endif
                            @if ($user = auth()
            ->user()
            ->socialAuthUser()
            ->where(['provider' => 'google'])
            ->first())
                                <div class="form-group m-2">

                                    <button type="button" class="btn bg-gradient-danger btn-sm"
                                        onclick="location.href = '{{ route('revoke.google') }}';"><i
                                            class="fab fa-google pr-1"></i>{{ $user->uid }} Connected</button>

                                </div>
                            @else
                                <div class="form-group m-2">

                                    <button type="button" class="btn bg-gradient-danger btn-sm"
                                        onclick="location.href = '{{ route('login.social', 'google') }}';"><i
                                            class="fab fa-google pr-1"></i> login with google</button>

                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>

@endsection
