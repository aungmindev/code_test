@extends('boilerplate::layout.index', [
    'title' => 'Client',
    'subtitle' => 'Clients Info',
    'breadcrumb' => ['Clients']]
)
{{-- @include('boilerplate::load.datatables') --}}
{{-- @include('boilerplate::load.datatables', ['fixedHeader' => true]) --}}
@section('content')
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
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#client">Add Clients <i class="fas fa-plus-circle ml-1"></i></button>
         </div>
     <div class="rounded table-light p-3 table-responsive" style="box-shadow: 0px 0px 3px rgba(0,0,0,.3)">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Users</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Deleted Users</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <table class="table table-striped table-hover" id="clientTable">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                        <tr>
                            <th scope="row">{{ $client->name == null ? '-' : $client->name}}</th>
                            <th scope="row">{{ $client->phone == null ? '-' : $client->phone }}</th>
                            <th scope="row">{{ $client->email == null ? '-' : $client->email }}</th>
                            <th scope="row">{{ $client->address == null ? '-' : $client->address}}</th>
                            <th scope="row">
                                <img  src="{{ asset('/storage/images/products/'.$client->photo) }}" style="width:30px;height:30px">
                                {{-- {{ $client->photo  == null ? '-' : $client->photo}} --}}
                            </th>
                            <td>
                            <i class="btn btn-warning btn-sm fas fa-edit rounded-circle" onclick="editClient('{{ $client->id }}')" id="eicon"></i>
                            <a href="{{ route('boilerplate.client.destroy' , ['id' => $client->id]) }}"><i class="btn btn-danger btn-sm rounded-circle fas fa-trash-alt" id="eicon"></i></a>
                            </td>
                          </tr>
                        @endforeach
        
                      </tbody>
        
                  </table>
          </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <table class="table table-striped table-hover" id="clientTable">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($trashclients as $trashclient)
                        <tr>
                            <th scope="row">{{ $trashclient->name == null ? '-' : $trashclient->name}}</th>
                            <th scope="row">{{ $trashclient->phone == null ? '-' : $trashclient->phone }}</th>
                            <th scope="row">{{ $trashclient->email == null ? '-' : $trashclient->email }}</th>
                            <th scope="row">{{ $trashclient->address == null ? '-' : $trashclient->address}}</th>
                            <th scope="row">{{ $trashclient->photo  == null ? '-' : $trashclient->photo}}</th>
                            <td>
                             <a href="{{ route('boilerplate.client.restore' , ['id' => $trashclient->id]) }}"><button class="btn btn-warning btn-sm p-2 rounded-circle btn-sm"  id="eicon"><i class="fas fa-redo-alt"></i></button></a>   
                            <a href="{{ route('boilerplate.client.forcedestroy' , ['id' => $trashclient->id]) }}"><i class="btn btn-danger btn-sm rounded-circle fas fa-trash-alt" id="eicon"></i></a>
                            </td>
                          </tr>
                        @endforeach
        
                      </tbody>
        
                  </table>
            </div>
          </div>
        

          <div class="modal fade" id="client" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Client</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ route('boilerplate.client.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                <div class="modal-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input name="name" type="text" required class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email address</label>
                          <input name="email" type="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Phone</label>
                          <input name="phone" type="text"  class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter Phone">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Address</label>
                          <input name="address" type="text"  class="form-control" id="address" placeholder="Enter Address">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Photo</label>
                            <input name="photo" type="file"  class="form-control-file" id="photo">
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

          {{-- edit modal --}}
          <div class="modal fade" id="clientEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Client</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ route('boilerplate.client.update') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                <div class="modal-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input name="name" type="text" required class="form-control" id="nameE" aria-describedby="emailHelp" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email address</label>
                          <input name="email" type="email"  class="form-control" id="emailE" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Phone</label>
                          <input name="phone" type="text"  class="form-control" id="phoneE" aria-describedby="emailHelp" placeholder="Enter Phone">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Address</label>
                          <input name="address" type="text"  class="form-control" id="addressE" placeholder="Enter Address">
                        </div>
                        <div class="form-group">
                          <input name="photoHN" type="hidden"  class="form-control" id="photoHN" placeholder="Enter Address">
                          <input name="clientId" type="hidden"  class="form-control" id="clientId" placeholder="Enter Address">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Photo</label>
                            <input name="photo" type="file"  class="form-control-file" id="photoE">
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
          {{ $clients->links() }}

     </div>
@endsection

<script>
   function editClient(id) {
    var table = document.getElementById('clientTable');
    rows  = table.getElementsByTagName('tr');
    for(var i = 1 ; i < rows.length ; i++){
        let img =  $('#photoE').attr('src');
      table.rows[i].onclick = function(){
       $('#nameE').val(this.cells[0].innerHTML)
       $('#phoneE').val(this.cells[1].innerHTML)
       $('#emailE').val(this.cells[2].innerHTML)
       $('#addressE').val(this.cells[3].innerHTML)
       $('#photoHN').val(this.cells[4].innerHTML)
       $('#photo').val('')
       $('#clientId').val(id)
           
    $('#clientEdit').modal('show')

      }
      
    }
    }
</script>