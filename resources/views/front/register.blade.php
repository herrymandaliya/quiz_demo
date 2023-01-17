<!DOCTYPE html>
<html lang="en">
   <head>
    @include('front.layouts.head', ['pagetitle' => ' - register'])
   </head>
   <body>
      <div class="main">
         <section class="signup">
            <div class="container">
               <div class="signup-content">
                    {!! Form::open(['url' => 'register/client', 'id' => 'formregistration','class'=>'signup-form']) !!}
                     <h2 class="form-title">Create account</h2>
                     <div class="form-group">
                        <label>Name</label>
                        {!! Form::text('name', '', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        {!! Form::email('email', '', ['class' => 'form-control']) !!}
                    </div>
                     <div class="form-group">
                        <label>Mobile Number</label>
                        {!! Form::number('phone_no', '', ['class' => 'form-control']) !!}
                     </div>

                    <div class="form-group">
                        <label>Password</label>
                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                    </div>

                    <div class="form-group">
                        <label>Repeat Password</label>
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>

                     <div class="form-group">
                        <input type="submit" name="submit" id="submit" class="form-submit" value="Sign up">
                     </div>
                     {!! Form::close() !!}
               </div>
            </div>
         </section>
      </div>
      @include('front.layouts.foot')
      <script src="{{ asset_front('/js/signup.js?ver=1.0.'.getCacheCounter()) }}"></script>
   </body>
</html>
