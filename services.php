<title>Petpark</title>
<?php
include 'header.php';
?>
<div class="container my-3">
    <div class="row bg-success p-5 align-items-center justify-content-between rounded-4">
        <div class="col-md-5 text-white fs-4">
            <div class="mb-3">
                At <strong>XZone</strong>, we are passionate about creating a better world for our furry friends. Our mission is to provide pet owners with a convenient and comprehensive platform for all their pet needs. Whether it's finding a new home for a shelter pet, arranging for pet care services, or helping pet owners connect with others in the pet breeding community, XZone is dedicated to making a positive impact on the lives of pets and their owners.
            </div>
            <div class="fs-5">
                <strong>Our Rates</strong>
                <ul>
                    <li>Small Pets: NRs. 200/day</li>
                    <li>Medium Pets: NRs. 350/day</li>
                    <li>Large Pets: NRs. 500/day</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <img src="https://cdn.pixabay.com/photo/2021/10/04/12/23/fox-6680137_960_720.png" class="img-fluid" />
        </div>
        <div class="col-md-12 text-center">
            <!-- #bookMyPet modal button -->
            <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#bookMyPet">
                Book Now
            </button>
        </div>
    </div>
    <!-- bookMyPet modal with pet name, service, data, time -->
    <div class="modal fade" id="bookMyPet" tabindex="-1" aria-labelledby="bookMyPetLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="bookings.php?action=book&service" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookMyPetLabel">Book Services</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="petName" class="form-label">Pet Name</label>
                        <input type="text" class="form-control" id="petName" placeholder="Pet Name" name="petName" required />
                    </div>
                    <div class="form-group mb-3">
                        <label for="service" class="form-label">Service</label>
                        <select class="form-select" id="service" name="service" required>
                            <option selected disabled>Select Service</option>
                            <option value="shelter">Pet Shelter</option>
                            <option value="care">Pet Care</option>
                            <option value="breeding">Pet Breeding</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="petSize" class="form-label">Pet Size</label>
                        <select class="form-select" id="petSize" name="petSize" required>
                            <option selected disabled>Select Pet Size</option>
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="large">Large</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" value="Save changes" />
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>