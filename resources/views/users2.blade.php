<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel dynamic auto load more page scroll examle</title>
    <link href="https://fonts.googleapis.com/css?family=Kanit:100,300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5" style="max-width: 550px">
        <h2></h2>
    <table class="table table-responsive table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>Code</th>
                <th width="50%" class="text-left">Sale Name</th>
                <th width="10%">Potision</th>
                <th width="1%">Actions</th>
            </tr>
        </thead>
        @php
        $z = 0;
        @endphp

        @foreach ($agents as $key => $item)
        <tbody>
            <tr class="clickable " data-toggle="collapse" data-target=".group-of-rows-{{$key}}" aria-expanded="false"
                aria-controls="group-of-rows-{{$key}}">

                <td><i class="fas fa-plus"></i></td>
                <td colspan="4">{{$item['teams']->name}}</td>
            </tr>
        </tbody>
        @isset($item['subteams'])
        @foreach ($item['subteams'] as $subteams)
        @isset($subteams['sub'])
        <tbody class="collapse group-of-rows-{{$key}}">
            <tr class="clickable leader " data-toggle="collapse" data-target=".list-of-rows-{{$z}}" aria-expanded="false"
                aria-controls="list-of-rows-{{$z}}">
                <td><i class="fas fa-plus"></i></td>
                <td>{{$subteams['sub']->id}}</td>
                <td>หัวหน้าทีม : {{$subteams['sub']->name}}</td>
                {{-- <td>{{ ($subteams['sub']->role()) ? $subteams['sub']->role()->name : ''  }}</td> --}}
                <td></td>
                <td class="text-center">
                    <ul class="m-auto p-0 list-unstyled">
                        <li class="dropdown action-menu">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-ellipsis-h pointer-cursor"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="" class="dropdown-item">Edit</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
        @foreach ($subteams['users'] as $i => $subteam)

        @if ($subteams['sub']->id == $subteam->id)
        @php
        continue;
        @endphp
        @endif
 
         <tbody class="collapse list-of-rows-{{$z}}">
            <tr>
                <td><i class="fas fa-minus"></i></td>
                <td>{{$subteam->id}}</td>
                <td>ลูกทีม : {{$subteam->name}}</td>
                <td>
                    <ul class="m-auto p-0 list-unstyled">
                        <li class="dropdown action-menu">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-ellipsis-h pointer-cursor"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="" class="dropdown-item">Edit</a>


                                <div class="dropdown-divider"></div>



                            </div>
                        </li>
                    </ul>

                </td>
            </tr>

        </tbody>

        @endforeach
        @endisset
        @php
        $z++;
        @endphp

        @endforeach
        @endisset

        @endforeach


    </table>

    </div>



</body>
</html>
