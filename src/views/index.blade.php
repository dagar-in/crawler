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
                    <h1 class="h2">Requests</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-danger">Clear All</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Download</button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">DateTime</th>
                                <th scope="col">Type</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paginator->items() as $log)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($log['created_at'])->isoFormat('MMM Do YYYY | h:m a')  }}</td>
                                    <td><span class="badge w-100 text-bg-{{ $log['type'] == 'request' ? 'primary' : 'info' }}">{{ $log['type'] }}</span></td>
                                    <td>{{ $log['request_id'] }}</td>
                                    <td>
                                        <a href="{{route('crawler.view',$log['id'])}}"
                                            type="button" class="btn btn-sm btn-info btn-outline-light">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($paginator->lastPage() > 1)
                    <nav aria-label="Logs navigation">
                        <ul class="pagination">
                            <li class=" page-item {{ $paginator->currentPage() == 1 ? ' disabled' : '' }}">
                                <a class="page-link " href="{{ $paginator->url(1) }}">Previous</a>
                            </li>
                            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                                <li class="page-item {{ $paginator->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link " href="{{ $paginator->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li
                                class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link "
                                    href="{{ $paginator->url($paginator->currentPage() + 1) }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                @endif

            </main>
        </div>
    </div>




</body>

</html>
