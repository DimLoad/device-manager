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
    
            // allow operations only if user is logged in and has permissions
            var loggedInUser = '<?= Auth::user()->name ?? "none" ?>';
            // gets back the user devices and populates the wrapper div with the result
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            // sends get request for user devices along with each device owner name if any
            // on success populates the devices div with returned data
            if ( loggedInUser != 'none') {
                $.ajax({
                    url: '/getUserDevices',
                    type: 'GET',
                    data: {_token: CSRF_TOKEN, userId : userId},
                    dataType: 'JSON',
                    success: function (data) { 
                        var devicesContent = '<h3>Devices Owned by ' + data['user']['name'] + '</h3>'
                        if(data['userDevices'].length > 0) {
                            $(data['userDevices']).each(function() {
                                devicesContent  +=  '<div class="card card-body bg-light mb-3">';
                                devicesContent  +=      '<h3>' + this['name']; 
                                devicesContent  +=      '<button type="button" class="close float-right" aria-label="Close" title="remove item" onclick="deallocateDevice(this,' + this['id'] + ', ' + userId + ')">';
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
                                    devicesContent  += '<option ' + disable + ' value="' + this['id'] + '">' + this['name'] + assignedTo + '</option>';                              
                                });
                            devicesContent += '</select>'; 
                            devicesContent += '<button class="form-control col-3 btn-dark" onclick="assignDevice(this, ' + userId + ')">Asign Device</button>'; 
                            devicesContent += '</div>';
                        }

                        $('.devicesWrapper').append(devicesContent);                        
                    }
                }); 
            } else {
                window.alert('You must be logged in to allocate devices!');
            }
        }

        function assignDevice(initiator, userId)
        {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var deviceId = $(initiator).parent().find('select').val();
            // sends post request with the new device-user pair 
            // on success adds the new device to the list of owned devices
            $.ajax({
                url: '/assignDevice',
                type: 'GET',
                data: {_token: CSRF_TOKEN, userId : userId, deviceId : deviceId},
                dataType: 'JSON',
                success: function (device) { 
                    if (device != 0) {
                        deviceContent   =  '<div class="card card-body bg-light mb-3">';
                        deviceContent  +=      '<h3>' + device['name']; 
                        deviceContent  +=      '<button type="button" class="close float-right" aria-label="Close" title="remove item" onclick="deallocateDevice(this,' + device['id'] + ', ' + userId + ')">';
                        deviceContent  +=          '<span aria-hidden="true">&times;</span>';
                        deviceContent  +=      '</button></h3>';           
                        deviceContent  +=  '</div>';

                        $('hr').before(deviceContent);  
                        // disables device in select
                        $('select option[value="' + device['id'] + '"]').first().prop('disabled', true);
                        // TO DO add 'assigned to' text 
                    } else {
                        window.alert('An error occured during this operation!');
                    }                      
                }
            }); 
        }            

        function deallocateDevice(initiator, deviceId, userId)
        {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // gets identity of signed in user
            var signedInUser = <?= !empty($userSignedIn) ? $userSignedIn : "none" ?>;
            // only allow operation for user's own devices or if user is admin
            if (signedInUser['id'] != userId && signedInUser['is_admin'] != 1) {
                window.alert('Error! You can only deallocate your own devices!');
            } else {
                $.ajax({
                    url: '/deallocateDevice',
                    type: 'GET',
                    data: {_token: CSRF_TOKEN, deviceId : deviceId},
                    dataType: 'JSON',
                    success: function (device) { 
                        if (device != 0) {
                            $(initiator).closest('.card').remove();
                            // enables device in select 
                            $('select option[value="' + deviceId + '"]').first().prop('disabled', false);
                            // TO DO remove 'assigned to' text 
                        } else {
                            window.alert('An error occured during this operation!');
                        }                      
                    }
                });  
            }          
        }
    </script>  
@endsection

