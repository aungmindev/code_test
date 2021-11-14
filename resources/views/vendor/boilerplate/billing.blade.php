@extends('boilerplate::layout.index', [
    'title' =>'Billing',
    'subtitle' => 'Billings info',
    'breadcrumb' => ['Billings']]
)

@section('content')
<style>
     #eicon {
        box-shadow: 0px 2px 5px rgba(32, 18, 236, 0.3)
     }
</style>
@foreach ($errors->all() as $error)
    <div class="alert alert-danger col-md-3 alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ $error }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
   @endforeach
   @if (\Session::has('success'))
    <div class="alert alert-success col-md-3 alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ \Session::get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
   @endif
    {{-- @include('boilerplate::plugins.demo') --}}
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#billing">Add Billing <i class="fas fa-plus-circle ml-1"></i></button>
     </div>
    <div class="rounded table-light p-3" style="box-shadow: 0px 0px 3px rgba(0,0,0,.3)">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Billings</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Deleted Bill</a>
            </div>
          </nav>
          <div class="tab-content table-responsive" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <table class="table table-striped" id="billingTable">
                    <thead>
                      <tr>
                        <th scope="col">Amount</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($billings as $billing)
                        <tr>
                            <th scope="row">{{ $billing->amount == null ? '-' : $billing->amount}}</th>
                            <th scope="row">{{ $billing->due_date == null ? '-' : $billing->due_date }}</th>
                            <th scope="row">{{ $billing->description == null ? '-' : $billing->description }}</th>
                            <td>
                            <i class="btn btn-warning btn-sm fas fa-edit rounded-circle" onclick="editClient('{{ $billing->id }}',{{ $billing->client_id }})" id="eicon"></i>
                            <a href="{{ route('boilerplate.billing.destroy' , ['id' => $billing->id]) }}"><i class="btn btn-danger btn-sm rounded-circle fas fa-trash-alt" id="eicon"></i></a>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <table class="table table-striped" id="billingTable">
                    <thead>
                      <tr>
                        <th scope="col">Client Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($trashedbillings as $trashedbilling)
                        <tr>
                            <th scope="row">{{ $trashedbilling->client_id == null ? '-' : $trashedbilling->client_id}}</th>
                            <th scope="row">{{ $trashedbilling->amount == null ? '-' : $trashedbilling->amount}}</th>
                            <th scope="row">{{ $trashedbilling->due_date == null ? '-' : $trashedbilling->due_date }}</th>
                            <th scope="row">{{ $trashedbilling->description == null ? '-' : $trashedbilling->description }}</th>
                            <td>
                                <a href="{{ route('boilerplate.billing.restore' , ['id' => $trashedbilling->id]) }}"><button class="btn btn-warning btn-sm p-2 rounded-circle btn-sm"  id="eicon"><i class="fas fa-redo-alt"></i></button></a>   
                               <a href="{{ route('boilerplate.billing.forcedestroy' , ['id' => $trashedbilling->id]) }}"><i class="btn btn-danger btn-sm rounded-circle fas fa-trash-alt" id="eicon"></i></a>
                               </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
          </div>
        

          <!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="billing" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Billing</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('boilerplate.billing.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="modal-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Amount</label>
                  <input name="amount" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Amount">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Due Date</label>
                  <input name="duedate" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Due Date">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Example select</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="clientid">
                       @foreach ($clients as $client)
                            <option  value="{{ $client->id }}">{{ $client->name }}</option>
                       @endforeach
                    </select>
                  </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea name="description" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Description"></textarea>
                </div>
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" type="button" class="btn btn-primary">Submit</button>
        </div>
    </form>

      </div>
    </div>
  </div>

   {{-- edit billing modal --}}
   <div class="modal fade" id="billingedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Billing</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('boilerplate.billing.update') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="modal-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Amount</label>
                  <input name="amount" type="text" class="form-control" id="amountE" aria-describedby="emailHelp" placeholder="Enter Amount">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Due Date</label>
                  <input name="duedate" type="date" class="form-control" id="duedateE" aria-describedby="emailHelp" placeholder="Enter Due Date">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Choose Client</label>
                    <select class="form-control"  name="clientid" id="clientidE">
                       @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                       @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <input name="id" type="hidden"  class="form-control" id="billingid" placeholder="Enter Address">
                  </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea name="description" type="text" class="form-control" id="descriptionE" aria-describedby="emailHelp" placeholder="Enter Description"></textarea>
                </div>
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" type="button" class="btn btn-primary">Submit</button>
        </div>
    </form>

      </div>
    </div>
  </div>
  {{ $billings->links() }}
     </div>
@endsection

<script>
    function editClient(id,clientId) {
     var table = document.getElementById('billingTable');
     rows  = table.getElementsByTagName('tr');
     for(var i = 1 ; i < rows.length ; i++){
         let img =  $('#photoE').attr('src');
       table.rows[i].onclick = function(){
        $('#amountE').val(this.cells[1].innerHTML)
        $('#duedateE').val(this.cells[2].innerHTML)
        $('#descriptionE').val(this.cells[3].innerHTML)
        $('#clientidE').val(clientId)
        $('#billingid').val(id)
            
     $('#billingedit').modal('show')
 
       }
       
     }
     }
 </script>