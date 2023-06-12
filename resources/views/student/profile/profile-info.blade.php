<div>
    <div class="row justify-content-center align-items-center g-3 mb-3">
        <div class="col-lg-6 col-md-9">
            <label class="form-label mb-0" for="">Name</label>
            <input type="text" class="form-control" v-model="user.name" disabled />
        </div>
        <div class="col-lg-6 col-md-9">
            <label class="form-label mb-0" for="">Year and Section</label>
            <input type="text" class="form-control" v-model="user.yearandsection" disabled />
        </div>
    </div>
    <div class="row justify-content-center align-items-center g-3 mb-3">
        <div class="col-lg-6 col-md-9">
            <label class="form-label mb-0" for="">Birthday</label>
            <input type="text" class="form-control" v-model="user.birthdate" disabled />
        </div>
        <div class="col-lg-6 col-md-9">
            <label class="form-label mb-0" for="">Gender</label>
            <input type="text" class="form-control" v-model="user.gender" disabled />
        </div>
    </div>
    <div class="row justify-content-center align-items-center g-3 mb-3">
        <div class="col-lg-6 col-md-9">
            <label class="form-label mb-0" for="">Phone No</label>
            <input type="text" class="form-control" v-model="user.phone_number" disabled />
        </div>
        <div class="col-lg-6 col-md-9">
            <label class="form-label mb-0" for="">Address</label>
            <input type="text" class="form-control" v-model="user.address" disabled />
        </div>
    </div>
</div>