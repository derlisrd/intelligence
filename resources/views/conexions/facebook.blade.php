@extends("layouts.app")

@section("title","Conectar con facebook")

@section("breadcrumb","Conectar con facebook")

@section("container")
<div class="my-5">
    <fb:login-button
  scope="email,attribution_read,ads_management,ads_read,public_profile,read_insights"
  onlogin="checkLoginState();">
</fb:login-button>
</div>



<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Usuarios ja conectados: </h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>FB USER ID</th>
                            <th>NOME</th>
                            <th>EMAIL</th>
                            <th>TOKEN</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fbusers as $user)
                            <tr>
                                <td>{{ $user->facebook_user_id  }}</td>
                                <td>{{ $user->name  }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ substr( $user->access_token,0,10 ); }}...</td>
                                <th><a href="#" class="btn btn-secondary">Refresh token</a> </th>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <tr>
                                <th>FB USER ID</th>
                                <th>NOME</th>
                                <th>EMAIL</th>
                                <th>TOKEN</th>
                                <th>Accion</th>
                            </tr>
                        </tr>
                    </tfoot>
                </table>
    </div>
</div>
@endsection


<script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '{{ env('FB_APP_ID') }}',
        cookie     : true,
        xfbml      : true,
        version    : '{{ env('FB_API_VERSION') }}'
      });

      FB.AppEvents.logPageView();

    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "https://connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));

     function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
  </script>
