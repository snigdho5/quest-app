@extends('admin.storepanel.master')

@section('content')

    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <div class="content-wrapper" >
      <section class="content">
        @if(session('success'))
          <p class="alert alert-success"><i class="fa fa-fw fa-check"></i>{{ session('success') }}</p>
        @endif
        
        <div class="row">
          <div class="col-sm-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title" style="display:block">Search User</h3>
              </div>
              <div class="box-body">
                <form action="" method="post" enctype="multipart/form-data" onsubmit="$('.button-submit').hide();$('.fa-spinner').show()">
                  {{ csrf_field()}}
                  <div class="form-group input-group input-group-sm">
                    <span class="input-group-addon">Coupon Code</span>
                    <input type="text" name="unique_code" autocomplete="off" class="form-control" value="{{request('unique_code')}}" placeholder="xxxxxx" required>
                    <span class="input-group-btn"><input type="submit" name="filter" class="btn btn-block btn-success" value="Search"></span>
                  </div>

                  @if(isset($message['error']))
                    <p class="alert alert-danger" style="padding: 5px 10px"><i class="fa fa-fw fa-warning"></i> {{ $message['error'] }}</p>
                  @endif

                  @if(request()->has('unique_code') and !isset($message['error']))
                    <p class="label-hr">Customer Details</p>
                    <div class="form-group input-group input-group-sm">
                      <span class="input-group-addon">Name</span>
                      <input type="text" class="form-control input-sm" value="{{$data->user->name}}" readonly>
                    </div>
                    <div class="form-group input-group input-group-sm">
                      <span class="input-group-addon">Phone</span>
                      <input type="text" class="form-control input-sm" value="{{$data->user->phone}}" readonly>
                    </div>
                    <div class="form-group input-group input-group-sm">
                      <span class="input-group-addon">Email</span>
                      <input type="text" class="form-control input-sm" value="{{$data->user->email}}" readonly>
                    </div>
                    <p class="label-hr">Offer Description</p>
                    <p>{{$data->offer_title}}</p>

                    @if ($available)
                    <p class="label-hr">Bill Amount</p>
                    <div class="form-group input-group input-group-sm">
                      <span class="input-group-addon"><i class="fa fa-inr fa-fw"></i></span>
                      <input type="number" step="0.01" min="1" class="form-control input-sm" autocomplete="off" name="amount" value="" placeholder="Enter the bill amount" required>
                    </div>

                    <div class="form-group text-center">
                      <input type="submit" name="submit" class="btn btn-block btn-warning button-submit" value="Accept Offer Code">
                      <i class="fa fa-spinner fa-spin fa-fw fa-lg" style="display: none"></i>
                    </div>

                    <div class="form-group">
                      <button type="button" class="btn btn-block btn-default  button-submit" onclick="window.location.href = '/admin/store-panel/apponlyoffer'"><i class="fa fa-refresh fa-fw"></i> Reset</button>
                    </div>
                    @else
                    <div class="form-group">
                      <p class="alert alert-danger" style="padding: 5px 10px"><i class="fa fa-close fa-fw"></i>The offer is currently not available!</p>
                      <label>Offer Availability:</label>
                      <table class="table table-condensed">
                        @foreach ($data->offer->activeday as $value)
                          <tr>
                            <td>{{$value->day}}</td>
                            <td>{{$value->fromtime}}</td>
                            <td>{{$value->totime}}</td>
                          </tr>
                        @endforeach
                      </table>
                    </div>
                    @endif
                  @endif
                  </form>
              </div>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title" style="display:block">Claimed App Exclusive Offers List</h3>
              </div>
              <div class="box-body">   
                <form class="row" action="" method="post" enctype="multipart/form-data">
                  {{ csrf_field()}}
                    <div class="col-sm-5">
                      <div class="input-group"><span class="input-group-addon">From Date</span><input type="text" name="start_date" value="{{request('start_date')}}" class="form-control" placeholder="Enter from date" required autocomplete="off"></div>
                    </div>
                    <div class="col-sm-5">
                      <div class="input-group"><span class="input-group-addon">To Date</span><input type="text" name="end_date" value="{{request('end_date')}}" class="form-control" placeholder="Enter to date" required autocomplete="off"></div>
                    </div>
                    
                    <div class="col-sm-2">
                      <button class="btn btn-block btn-warning btn-sm">Filter</button>
                    </div>
                </form>
                <hr>
                <table id="listtable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Coupon</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Offer</th>
                      <th>Amount (Rs.)</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($claimedOffers as $value)
                    <tr>
                      <td>{{$value->updated_at->format('M d, Y - h:i a')}}</td>
                      <td>{{$value->code}}</td>
                      <td>{{$value->user->name}}</td>
                      <td>{{$value->user->phone}}</td>
                      <td>{{$value->user->email}}</td>
                      <td>{{$value->offer_title}}</td>
                      <td>{{$value->amount}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </section>
    </div>

    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


    <script src="bower_components/datatables.net/js/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
    <script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.bootstrap.min.js"></script>
    <script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.html5.min.js"></script>

    <script>

      $(document).ready(function() {
        $('[name="start_date"]').datetimepicker({format: 'YYYY-MM-DD'});
        $('[name="end_date"]').datetimepicker({format: 'YYYY-MM-DD'});
       $('#listtable').DataTable({
      dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          'filename':'Claimed_offer_list_{{date('Y-m-d')}}',
          'extend':'excelHtml5',
          
          'text':'<i class="fa fa-download fa-fw"></i> Download'
        },
        {
          'filename':'Claimed_offer_list_{{date('Y-m-d')}}',
          'extend':'excelHtml5',
          'exportOptions':{
            'modifier': {
              'search': 'none',
              'order': 'applied'
            }
          },
          'text':'<i class="fa fa-download fa-fw"></i> Download All'
        },
      ]
    })
      });

      function calculateAmount(input) {
        $('.error-amount').hide();
        var percentage = parseFloat($("input[name=percentage]").val());
        var transAmount = parseFloat($(input).val());
        var Minimumbill = parseFloat($('#min_bill').html());
        var Maxdiscount =parseFloat($('#max_discount').html());
        if(isNaN(transAmount)){
          $('.error-amount').show();
          $('.error-amount').html('Please enter bill amount.');
        }else{
          if(transAmount >= Minimumbill){
            var discount = (transAmount*percentage)/100;
          }else{
            var discount = 0;
          }

          if(discount > Maxdiscount){
            var result = transAmount-Maxdiscount;
          }else{
            var result = transAmount-discount;
          }
          
          
          $("input[name=dis_amount]").val(result);
          if(discount>0){ 
             $('.button-submit').show();
          }else{
            $('.error-amount').show();
            $('.error-amount').html('Minimum bill amount must be at least Rs.'+Minimumbill);
            $('.button-submit').hide();
          }
        }

      }
    </script>
@endsection