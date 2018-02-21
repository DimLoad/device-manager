@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">{{$title}}</h1>
        <div class="row  mt-4">
            <div class="col-sm-4">
                <h3>Team Members</h3>
                @if(count($users) > 1)
                    @foreach ($users as $user) 
                        <div class="user-card card card-body bg-light mb-3" onclick="showDevices({{$user->id}})" data-toggle="tooltip" data-placement="bottom" title="show this user's devices">
                            <h3>{{$user->name}}</h3>             
                        </div>
                    @endforeach
                @else
                    No users are currently registered.
                @endif
            </div>
            <div class="devicesWrapper col-sm-7 offset-sm-1"></div>
        </div>
    </div>
    
    <script> 
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function showDevices(userId)
        {
            $('.devicesWrapper').empty();
            
            var users = <?= $users ?>;
            // gets back the user devices and populates the wrapper div with the result
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                    url: '/getUserDevices',
                    type: 'GET',
                    data: {_token: CSRF_TOKEN, userId : userId},
                    dataType: 'JSON',
                    success: function (data) { 
                        var devicesContent = '<h3>Devices Owned</h3>'
                        if(data['userDevices'].length > 0) {
                            $(data['userDevices']).each(function() {
                                devicesContent  +=  '<div class="card card-body bg-light mb-3">';
                                devicesContent  +=      '<h3>' + this['name']; 
                                devicesContent  +=      '<button type="button" class="close float-right" aria-label="Close" title="remove item" onclick="dealocateDevice(this,' + this['id'] + ')">';
                                devicesContent  +=          '<span aria-hidden="true">&times;</span>';
                                devicesContent  +=      '</button></h3>';           
                                devicesContent  +=  '</div>';
                            });
                        } else {
                            devicesContent += 'No devices are currently assigned to this user.';
                        }

                        if(data['devices'].length > 0) { 
                            devicesContent  += '<hr>';
                            devicesContent += '<div class="form-row">';
                            devicesContent += '<select class="form-control col-sm-9">';
                            devicesContent  += '<option value="0"> - select a device - </option>';   
                                $(data['devices']).each(function() {
                                    var assignedTo = this['ownerName']  != null ? ' - assigned to ' + this['ownerName'] : ''; 
                                    var disable = assignedTo != '' ? 'disabled' : '';
                                    devicesContent  += '<option ' + disable + '>' + this['name'] + assignedTo + '</option>';                              
                                });
                            devicesContent += '</select>'; 
                            devicesContent += '<button class="form-control col-3 btn-dark">Asign Device</button>'; 
                            devicesContent += '</div>';
                        }

                        $('.devicesWrapper').append(devicesContent);                        
                    }
            }); 
        }  
    </script>  
@endsection

