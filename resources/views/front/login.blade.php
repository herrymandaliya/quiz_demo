<!DOCTYPE html>
<html lang="en">
   <head>
    @include('front.layouts.head', ['pagetitle' => ' - Login'])
   </head>
   <body>
      <div class="main">
         <section class="signup">
            <div class="container">
               <div class="signup-content">
                    {!! Form::open(['url' => 'login/client', 'id' => 'formlogin','class'=>'login-form']) !!}
                     <h2 class="form-title">Login</h2>
                     
                    <div class="form-group">
                        <label>Phone or Email</label>
                        {!! Form::text('login', '', ['class' => 'form-control']) !!}
                    </div>
                     
                    <div class="form-group">
                        <label>Password</label>
                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                    </div>
                     <div class="form-group">
                        <input type="submit" name="submit" id="submit" class="form-submit" value="Login">
                     </div>
                     {!! Form::close() !!}
                     <div class="float-right"><span>You don't have account?</span><a href="{{url('/register')}}">register</a></div>
               </div>
            </div>
         </section>
      </div>
      @include('front.layouts.foot')
      <script src="{{ asset_front('/js/login.js?ver=1.0.'.getCacheCounter()) }}"></script>
   </body>
</html>
