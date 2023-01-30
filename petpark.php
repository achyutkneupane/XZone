<title>Petpark</title>
<?php
include 'header.php';
?>
<div class="container my-3">
    <div class="row bg-success p-5 align-items-center justify-content-between rounded-4">
        <div class="col-md-5 text-white fs-4">
            <div class="mb-3">
                At <strong>Pet Park</strong>, we are passionate about creating a better world for our furry friends. Our mission is to provide pet owners with a convenient and comprehensive platform for all their pet needs. Whether it's finding a new home for a shelter pet, arranging for pet care services, or helping pet owners connect with others in the pet breeding community, Pet Park is dedicated to making a positive impact on the lives of pets and their owners.
            </div>
            <div class="fs-5">
                <strong>Our Rates</strong>
                <ul>
                    <li>Small Pets: NRs. 500/hr</li>
                    <li>Medium Pets: NRs. 1000/hr</li>
                    <li>Large Pets: NRs. 1500/hr</li>
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
</div>
<?php
include 'footer.php';
?>