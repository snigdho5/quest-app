@extends('admin.layout.master')
@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="fa fa-users fa-fw"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Registered Users</span>
              <span class="info-box-number">{{$total_user}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>

        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="material-icons">directions_run</i></span>

            <div class="info-box-content">
              <span class="info-box-text">WalknWin Users</span>
              <span class="info-box-number">{{$wnw_user}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>

        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="material-icons">verified</i></span>

            <div class="info-box-content">
              <span class="info-box-text">WalknWin Offer Redeemed</span>
              <span class="info-box-number">{{$wnw_redeem}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
      </div>
      <p class="label-hr">Pre-Booking</p>
      <div class="row">
        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="material-icons">confirmation_number</i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Bookings</span>
              <span class="info-box-number">{{$total_booking}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>

        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive">{{date('d')}}</span>

            <div class="info-box-content">
              <span class="info-box-text">Today's Bookings</span>
              <span class="info-box-number">{{$today_booking}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>

        

        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="material-icons">visibility_off</i></span>

            <div class="info-box-content">
              <span class="info-box-text">No Show</span>
              <span class="info-box-number">{{$no_booking}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>

        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="material-icons">no_meeting_room</i></span>

            <div class="info-box-content">
              <span class="info-box-text">Cancelled Bookings</span>
              <span class="info-box-number">{{$cancel_booking}}</span>

              <div class="progress"><div class="progress-bar" style="width: 0%"></div></div>
              <span class="progress-description">Today: {{$today_cancel_booking}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>

        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="material-icons">login</i></span>

            <div class="info-box-content">
              <span class="info-box-text">Entry Logged</span>
              <span class="info-box-number">{{$entry_booking}}</span>
              <div class="progress"><div class="progress-bar" style="width: 0%"></div></div>
              <span class="progress-description">Today: {{$today_entry_booking}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>

        <div class="col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="material-icons">nat</i></span>

            <div class="info-box-content">
              <span class="info-box-text">Exit Logged</span>
              <span class="info-box-number">{{$exit_booking}}</span>
              <div class="progress"><div class="progress-bar" style="width: 0%"></div></div>
              <span class="progress-description">Today: {{$today_exit_booking}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection