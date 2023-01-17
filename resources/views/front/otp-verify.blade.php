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
                    {!! Form::open(['url' => 'otp/verify', 'id' => 'formotpverify','class'=>'verify-form']) !!}
                     <h2 class="form-title">verify Otp</h2>
                    

                    <div class="form-group">
                        <label>Enter Otp</label>
                        {!! Form::number('otpverify', '', ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::hidden('user_id', $id, ['class' => 'form-control']) !!}
                     <div class="form-group">
                        <input type="submit" name="submit" id="submit" class="form-submit" value="otp submit">
                     </div>
                     {!! Form::close() !!}
               </div>
            </div>
         </section>
      </div>
      @include('front.layouts.foot')
      <script src="{{ asset_front('/js/otp-verify.js?ver=1.0.'.getCacheCounter()) }}"></script>
   </body>
</html>
