@extends('layouts.app')

@section('content')
<div class="container-create">
    <h1 class="mb-4">Create Booking</h1>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Vehicle Name</th>
                <th>Type</th>
                <th>Fuel Consumption</th>
                <th>Last Service Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->name }}</td>
                    <td>{{ $vehicle->type }}</td>
                    <td>{{ $vehicle->fuel_consumption }} L/KM</td>
                    <td>{{ $vehicle->last_service_date }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bookingModal" data-vehicle-id="{{ $vehicle->id }}">
                            Book
                        </button>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateServiceDateModal" data-vehicle-id="{{ $vehicle->id }}" data-last-service-date="{{ $vehicle->last_service_date }}">
                            Last Service
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Booking Form Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Booking Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="vehicle_id" id="modal_vehicle_id">
                        <div class="form-group">
                            <label for="requested_by">Requested By</label>
                            <input type="text" name="requested_by" id="requested_by" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="approver_level_1">Approver Level 1</label>
                            <select name="approver_level_1" id="approver_level_1" class="form-control" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="approver_level_2">Approver Level 2</label>
                            <select name="approver_level_2" id="approver_level_2" class="form-control" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" name="start_date" id="start_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" name="end_date" id="end_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea name="reason" id="reason" class="form-control" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Last Service Date Modal -->
<div class="modal fade" id="updateServiceDateModal" tabindex="-1" role="dialog" aria-labelledby="updateServiceDateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateServiceDateModalLabel">Update Last Service Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vehicles.updateServiceDate') }}" method="POST" id="updateServiceDateForm">
                    @csrf
                    <input type="hidden" name="vehicle_id" id="update_vehicle_id">
                    <div class="form-group">
                        <label for="last_service_date">Last Service Date</label>
                        <input type="text" name="last_service_date" id="last_service_date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Date</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize datepickers for start_date and end_date
        $('#start_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('#end_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        // Listen for the modal show event
        $('#bookingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var vehicleId = button.data('vehicle-id'); // Extract info from data-* attributes

            console.log("Vehicle ID: ", vehicleId); // Tambahkan log ini untuk debugging

            // Update the modal's content
            var modal = $(this);
            modal.find('#modal_vehicle_id').val(vehicleId);
            modal.find('#requested_by').val(''); // Clear input
            modal.find('#start_date').val(''); // Clear input
            modal.find('#end_date').val(''); // Clear input
            modal.find('#reason').val(''); // Clear input

            // Fetch booked dates for the selected vehicle
            $.ajax({
                url: "{{ url('/bookings/booked-dates') }}/" + vehicleId,
                method: "GET",
                success: function(data) {
                    var bookedDates = data;
                    console.log("Booked Dates: ", bookedDates); // Log booked dates for debugging

                    // Disable booked dates in the date pickers
                    $('#start_date, #end_date').datepicker('option', 'beforeShowDay', function(date) {
                        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                        return [bookedDates.indexOf(string) == -1];
                    });
                }
            });
        });

        $('#updateServiceDateModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var vehicleId = button.data('vehicle-id'); // Extract vehicle ID
            var lastServiceDate = button.data('last-service-date'); // Extract last service date

            // Update the modal's content
            var modal = $(this);
            modal.find('#update_vehicle_id').val(vehicleId);
            modal.find('#last_service_date').val(lastServiceDate); // Set the last service date

            // Initialize datepicker for last service date
            $('#last_service_date').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    });
</script>
@endsection
