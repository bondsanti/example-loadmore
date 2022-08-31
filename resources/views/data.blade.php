@foreach($teams as $team)
<div>
    <h3><a href="">{{ $team->name }}</a></h3>
    {{-- <p>{{ str_limit($team->name, 400) }}</p> --}}

    {{-- <div class="text-right">
        <button class="btn btn-success">Read More</button>
    </div> --}}

    <hr style="margin-top:5px;">
</div>
@endforeach