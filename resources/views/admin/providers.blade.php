@extends('layouts.admin')

@section('title', 'Providers | ')

@section('content')
        <div class="panel">
          <div class="panel-heading border">
            <ol class="breadcrumb mb0 no-padding">
              <li>
                <a href="javascript:;">Home</a>
              </li>
              <li>
                <a href="javascript:;">Providers</a>
              </li>
              <li class="active">Providers List</li>
            </ol>
          </div>
          <div class="panel-body">
            <table class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Total Services</th>
                  <th>Amount Paid</th>
                  <th>Status</th>
                  <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              @for($i=1; $i < 15; $i++)
              <tr>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td><div class="col-sm-10">

                      <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                      </div></td>
              </tr>
              @endfor
              </tbody>
            </table>
          </div>
        </div>

@endsection

@section('scripts')<!-- page level scripts -->
  <script src="{{ asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
  <!-- /page level scripts -->

  <!-- initialize page scripts -->
  <script src="{{ asset('admin_assets/scripts/extensions/bootstrap-datatables.js') }}"></script>
  <script src="{{ asset('admin_assets/scripts/pages/datatables.js') }}"></script>
@endsection
