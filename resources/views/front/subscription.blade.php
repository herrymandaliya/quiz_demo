<!DOCTYPE html>
<html>
<head>
    @include('front.layouts.head', ['pagetitle' => ' - register'])
</head>
<body style="background-color: darkslategray;">


    <div id="myForm" >
        <div class="tab">
            <section class="" id="pricing">
                <!--begin container -->
                <div class="container">
                <!--begin row -->
                <div class="row">
                    <!--begin col-md-4-->
                    <div class="col-md-4">
                        <div class="price-box" data-planid="price_1KCNa7LLK8La6m9vnsPy6dIH">
                            <ul class="pricing-list">
                            <li class="price-title">BASIC</li>
                            <li class="price-value">$25</li>
                            <li class="price-subtitle">Per Month</li>
                            <li class="price-text"><i class="fas fa-check blue"></i>Custom Charts</li>
                            <li class="price-text"><i class="fas fa-check blue"></i>5 Mailboxes, 10 Gb Storage</li>
                            <li class="price-text"><i class="fas fa-check blue"></i>Unlimited Free Dashboards</li>
                            <li class="price-text"><i class="fas fa-check blue"></i>Access to all APIs</li>
                            <li class="price-tag-line"><a href="#">FREE 15-DAY TRIAL</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--end col-md-4 -->
                    <!--begin col-md-4-->
                    <div class="col-md-4">
                        <div class="price-box" data-planid="price_1KCNZmLLK8La6m9vpASCoprK">
                            <div class="ribbon blue"><span>Popular</span></div>
                            <ul class="pricing-list">
                            <li class="price-title">STANDARD</li>
                            <li class="price-value">$99</li>
                            <li class="price-subtitle">Per Month</li>
                            <li class="price-text strong"><i class="fas fa-check blue"></i><strong>All Basic features</strong></li>
                            <li class="price-text"><i class="fas fa-check blue"></i>15 Mailboxes, 50 Gb Storage</li>
                            <li class="price-text"><i class="fas fa-check blue"></i>Interactive Screen Sharing</li>
                            <li class="price-text"><i class="fas fa-check blue"></i>Full Reports History</li>
                            <li class="price-tag"><a href="#">FREE 15-DAY TRIAL</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--end col-md-4 -->
                    <!--begin col-md-4-->
                    <div class="col-md-4">
                        <div class="price-box" data-planid="price_1KCNZPLLK8La6m9v6GJwlUKV">
                            <ul class="pricing-list">
                            <li class="price-title white-text">PRO</li>
                            <li class="price-value white-text">$199</li>
                            <li class="price-subtitle white-text">Per Month</li>
                            <li class="price-text white-text"><i class="fas fa-check blue"></i><strong>All Standard Features</strong></li>
                            <li class="price-text"><i class="fas fa-check blue"></i>50 Mailboxes, 90 Gb Storage</li>
                            <li class="price-text"><i class="fas fa-check blue"></i>Dedicated Account Manager</li>
                            <li class="price-text"><i class="fas fa-check blue"></i>24/7 Priority Support</li>
                            <li class="price-tag-line"><a href="#">FREE 15-DAY TRIAL</a></li>
                            </ul>
                        </div>
                    </div>

                    <!--end col-md-4 -->
                </div>
                <!--end row -->
                </div>
                <!--end container -->
            </section>
        </div>
        <div class="tab">
            {!! Form::open(['url' => 'register/client', 'id' => 'formregistration','class'=>'signup-form']) !!}
            <input type="hidden" name="stripeToken" id="stripeToken">
            <input type="hidden" name="product_key" class="product-key" value="">
            <div class="main">
                <section class="signup">
                <div class="container">
                    <div class="signup-content">
                        <h2 class="form-title">Create account</h2>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>First Name</label>
                                {!! Form::text('firstname', '', ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                <label>Last Name</label>
                                {!! Form::text('lastname', '', ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                {!! Form::email('email', '', ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                <label>Password</label>
                                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                <label>Repeat Password</label>
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                <label>Phone Number</label>
                                {!! Form::number('phone_no', '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                </section>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="tab">
            <form action="/charge" method="post" id="payment-form">
                <div class="container">
                    <div class="form-group ">
                        <label for="card-element">
                            Credit or debit card
                        </label>
                        <div id="card-element" class="form-control">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display Element errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                <button>Submit Payment</button>
            </div>
            </form>
        </div>
        <div style="overflow:auto;">
            <div style="float:right; margin-top: 5px;">
                <button type="button" class="previous">Previous</button>
                <button type="button" class="next">Next</button>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    @include('front.layouts.foot')

    <script>

    </script>
</body>
</html>
