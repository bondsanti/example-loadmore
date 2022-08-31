<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Laravel load more page scroll</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>

  {{-- <div class="container">
   <div class="wrapper">

    <ul id="results"><!-- results appear here --></ul>
     <div class="ajax-loading"><button class="btn btn-primary">โหลดเพิ่มเติม</button></div>
   </div>
  </div> --}}

  <div class="container">

    <div class="wrapper">
     <ui>    {{ csrf_field() }}
        <div id="post_data"></div></ui>
    </div>

  </div>

</body>
</html>
<script>
    $(document).ready(function(){

     var _token = $('input[name="_token"]').val();

     load_data('', _token);

     function load_data(id="", _token)
     {
      $.ajax({
       url:"{{ route('loadmore.load_data') }}",
       method:"POST",
       data:{id:id, _token:_token},
       success:function(data)
       {
        $('#load_more_button').remove();
        $('#post_data').append(data);
       }
      })
     }

     $(document).on('click', '#load_more_button', function(){
      var id = $(this).data('id');
      $('#load_more_button').html('<b>Loading...</b>');
      load_data(id, _token);
     });

    });
    </script>


