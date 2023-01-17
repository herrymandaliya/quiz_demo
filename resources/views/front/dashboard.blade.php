@extends('front.layouts.head')

@section('pagetitle', ' - Dashboard')

@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome Admin!</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
           <div class="card dash-widget">
              <div class="card-body">
                 <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                 <div class="dash-widget-info">

                    <h3></h3>
                    <span>Projects</span>
                 </div>
              </div>
           </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
           <div class="card dash-widget">
              <div class="card-body">
                 <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                 <div class="dash-widget-info">
                    <h3></h3>
                    <span>Clients</span>
                 </div>
              </div>
           </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
           <div class="card dash-widget">
              <div class="card-body">
                 <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                 <div class="dash-widget-info">
                    <h3></h3>
                    <span>Total Media</span>
                 </div>
              </div>
           </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
           <div class="card dash-widget">
              <div class="card-body">
                 <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                 <div class="dash-widget-info">
                    <h3></h3>
                    <span>Member</span>
                 </div>
              </div>
           </div>
        </div>
     </div>

@endsection