<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex, nofollow">

    <title>Crawler {{ config('app.name') ? ' - ' . config('app.name') : '' }}</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link href="https://fonts.bunny.net/css?family=Karla" rel="stylesheet">

    <link href="{{ asset('app.css') }}" rel="stylesheet" type="text/css">
</head>

<?php
function isJson($string)
{
    if (gettype($string) != 'string') {
        return true;
    }
    json_decode($string);
    return json_last_error() == JSON_ERROR_NONE;
}

?>

<body>


    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6"
            href="#">Crawler{{ config('app.name') ? ' - ' . config('app.name') : '' }}</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search"
            aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#">Search</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="{{ route('crawler.dashboard') }}?type=requests">
                                <span data-feather="home" class="align-text-bottom"></span>
                                Requests
                            </a>
                        </li>

                    </ul>

                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span>Docs</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle" class="align-text-bottom"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text" class="align-text-bottom"></span>
                                Version 1
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">{{ ucfirst($log['type']) }}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-danger">Clear</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Download</button>
                        </div>
                    </div>
                </div>

                <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h6 class="border-bottom pb-2 mb-0">Request</h6>

@if ($log['type'] == 'query')

                    <div class="d-flex text-muted pt-3">
                        <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
                            <strong class="d-block text-gray-dark">Query</strong>
                            {{ $log['content'][0][0] }}
                        </p>
                    </div>

                    <div class="d-flex text-muted pt-3">
                        <p class="d-block pb-3 mb-0 small lh-sm border-bottom w-100">
                            <strong class="d-block text-gray-dark">Bindings</strong>
                        </p>

                    </div>
                    <ul class="d-block col-12">
                            @foreach ($log['content'][1] as $params)
                                <li>{{$params}}</li>
                            @endforeach
                        </ul>

                    <div class="d-flex text-muted pt-3">
                        <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
                            <strong class="d-block text-gray-dark">Time</strong>
                            {{ $log['created_at'] }}
                        </p>
                    </div>

@else

                    @foreach ($log['content'] as $item => $value)

                        @if ($item == 'headers')
                            <div class="d-flex text-muted pt-3">
                             <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title></title>
                                <rect width="100%" height="100%" fill="#007bff"></rect><text x="50%"
                                    y="50%" fill="#007bff" dy=".3em">32x32</text>
                            </svg>
                                <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                    <strong class="d-block text-gray-dark">{{ $item }}</strong>

                                    <ul>
                                        @foreach ($value as $vKey => $vVal)

                                                <li class="pb-3 mb-0 small lh-sm border-bottom">
                                                    <b class="d-block text-gray-dark">{{ ucfirst($vKey) }}</b>
                                                    {{ gettype($vVal) == 'array' ? json_encode($vVal) : $vVal }}
                                                </li>
                                        @endforeach
                                    </ul>

                                </p>
                            </div>
                            @continue
                        @endif

                        <div class="d-flex text-muted pt-3">
                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title></title>
                                <rect width="100%" height="100%" fill="#007bff"></rect><text x="50%"
                                    y="50%" fill="#007bff" dy=".3em">32x32</text>
                            </svg>

                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark">{{ ucfirst($item) }}</strong>
                                {{ gettype($value) == 'array' ? json_encode($value) : $value }}

                            </p>
                        </div>
                    @endforeach
@endif

                </div>

            </main>
        </div>
    </div>




</body>

</html>
