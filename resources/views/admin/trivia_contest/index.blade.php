@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Trivia Contest
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Trivia Contest</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    @if(session('success'))
      <p class="alert alert-success"><i class="fa fa-fw fa-check"></i>{{ session('success') }}</p>
    @endif
    @if(session('error'))
      <p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>{{ session('error') }}</p>
    @endif

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Participants of day 
          <form action="" method="post" style="display: inline-block">
            {{ csrf_field()}}
            <select name="day" class="no-select2" style="border:none; outline: none" onchange="this.form.submit()">
              <option {{request('day')==1?'selected':''}}>1</option>
              <option {{request('day')==2?'selected':''}}>2</option>
              <option {{request('day')==3?'selected':''}}>3</option>
              <option {{request('day')==4?'selected':''}}>4</option>
              <option {{request('day')==5?'selected':''}}>5</option>
              <option {{request('day')==6?'selected':''}}>6</option>
              <option {{request('day')==7?'selected':''}}>7</option>
            </select>
          </form>
        </h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Contact</th>
              <th>Email</th>
              <th>Score</th>
            </tr>
          </thead>
          <tbody>
            @foreach($alldata as $value)
              <tr>
                <td>{{ $value->user->name }}</td>
                <td>{{ $value->user->phone }}</td>
                <td>{{ $value->user->email }}</td>
                <td>{{ $value->score }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    $('#listtable').DataTable({
      order:['3','desc']
    })
  });
</script>



@endsection