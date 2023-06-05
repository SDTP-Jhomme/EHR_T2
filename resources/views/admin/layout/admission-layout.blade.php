<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/table.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/laboratory.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/bootstrap.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/fontawesome/css/all.min.css') ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">

<title>@yield('title')</title>
<div id="app">
    <div v-if="fullscreenLoading" class="fullscreen-loading">
        <div class="spinner-heart" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="spinner-text">Loading...</span>
    </div>
    <!-- header -->
    <header id="header" class="sticky-top nav-bg">
        <nav class="navbar">
            <div class="container-fluid d-flex align-items-center">
                <div class="me-3">
                    <a class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="collapse" href="#sidebar" aria-expanded="false" aria-controls="sidebar">
                        <i class="fas fa-bars" style="color: #fff;"></i>
                    </a>
                    <img class="w-25 img-fluid rounded-circle" src="<?php echo asset('storage/assets/img/logo.png') ?>" alt="Logo image"> </a>
                </div>
                <div class="nav">
                    <li class="nav-item">
                        <div class="ms-auto mt-auto">
                            <div class="dropstart user-dropdown">
                                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img class="img-xs rounded-circle" src="<?php echo asset('storage/assets/avatar/default.png') ?>" alt="Profile image"> </a>
                                <div class="dropdown-menu" aria-labelledby="UserDropdown">
                                    <div class="dropdown-header text-center">
                                        <img class="img-md rounded-circle" src="<?php echo asset('storage/assets/avatar/default.png') ?>" alt="Profile image">
                                        <p class="mb-1 mt-3 fw-light text-muted">Allen Moreno</p>
                                    </div>
                                    <div class="dropdown-item">
                                        <a class="nav-link" href="{{route('adminLogout')}}">
                                            <i class="fas fa-power-off text-danger me-2"></i>
                                            Sign Out
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </div>
            </div>
        </nav>
    </header>
    @yield('header')
    <!-- sidebar -->
    <div class="container-fluid page-wrapper">
        <aside id="sidebar" class="collapse collapse-horizontal show sidebar">
            <ul class="nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('admin-dashboard')}}">
                        <i class="fas fa-th-large pe-2"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('admin-dashboard')}}">
                        <i class="fas fa-th-large pe-2"></i>
                        <span class="menu-title">Appointments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#Registration" aria-expanded="false" aria-controls="Registration">
                        <i class="fas fa-users pe-2"></i>
                        <span class="menu-title">Registration</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="Registration">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin-admission')}}"><i class="fas fa-user pe-2"></i>Nurse</a>
                            </li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin-admission')}}"><i class="fas fa-user pe-2"></i>Adviser</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- <li class="nav-item nav-category">Admissions</li> -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#students" aria-expanded="false" aria-controls="students">
                        <i class="fas fa-users pe-2"></i>
                        <span class="menu-title">Patients</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="students">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin-admission')}}"><i class="fas fa-user pe-2"></i>Admissions</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#payment" aria-expanded="false" aria-controls="payment">
                        <i class="fas fa-cash-register pe-2"></i>
                        <span class="menu-title">Medical Records</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="payment">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/buttons.html"><i class="fas fa-money-bill-alt pe-2"></i>CBC</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/dropdowns.html"><i class="fas fa-receipt pe-2"></i>Urinalysis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/dropdowns.html"><i class="fas fa-receipt pe-2"></i>Fecalysis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/dropdowns.html"><i class="fas fa-receipt pe-2"></i>X-ray</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/dropdowns.html"><i class="fas fa-receipt pe-2"></i>Hepa Antigen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/dropdowns.html"><i class="fas fa-receipt pe-2"></i>Hepa Vaccine</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </aside>
        @yield('sidebar')
    </div>
</div>
<script src="<?php echo asset('storage/assets/js/bootstrap.bundle.js') ?>"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script>
    // ELEMENT.locale(ELEMENT.lang.en)
    new Vue({
        el: '#app',
        data() {
            return {
                maxDate: new Date().toISOString().split("T")[0],
                fullscreenLoading: true,
                active: 0,
                tableData: [],
                tableLoad: false,
                openAddDialog: false,
                openAddDrawer: false,
                isCBC: false,
                isUrinalysis: false,
                isFecalysis: false,
                isXray: false,
                isAntigen: false,
                isVaccine: false,
                checkIdentification: [],
                identification: "",
                password: "",
                year: "",
                course: "Nursing",
                firstname: "",
                midname: "",
                lastname: "",
                gender: "",
                phone_number: "",
                birthdate: "",
                civil: "",
                citizen: "",
                street: "",
                brgy: "",
                city: "",
                identificationError: "",
                yearError: "",
                firstnameError: "",
                midnameError: "",
                lastnameError: "",
                genderError: "",
                phoneError:"",
                birthdateError: "",
                civilError: "",
                citizenError: "",
                streetError: "",
                brgyError: "",
                cityError: "",
            };
        },
        created() {
            this.getData()
        },
        mounted() {
            this.getData();
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)
            this.active = localStorage.active ? parseInt(localStorage.active) : 0

            this.isCBC = localStorage.isCBC ? localStorage.isCBC : false
            this.isUrinalysis = localStorage.isUrinalysis ? localStorage.isUrinalysis : false
            this.isFecalysis = localStorage.isFecalysis ? localStorage.isFecalysis : false
            this.isXray = localStorage.isXray ? localStorage.isXray : false
            this.isAntigen = localStorage.isAntigen ? localStorage.isAntigen : false
            this.isVaccine = localStorage.isVaccine ? localStorage.isVaccine : false

            const today = new Date();
            const options = {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            };

            const date = today.toLocaleDateString("en-US", options).split('/').reverse().join('/');
            localStorage.setItem("date", date);

            this.requestDate = localStorage.date ? localStorage.date : "01/01/1970";

            const formData = JSON.parse(localStorage.getItem('formData'));
            this.age = localStorage.age ? localStorage.age : 0

            if (formData) {
                // Assign the retrieved data to the component's properties
                this.identification = formData.identification;
                this.year = formData.year;
                this.course = formData.course;
                this.firstname = formData.firstname;
                this.midname = formData.midname;
                this.lastname = formData.lastname;
                this.gender = formData.gender;
                this.phone_number = formData.phone_number;
                this.birthdate = formData.birthdate;
                this.civil = formData.civil;
                this.citizen = formData.citizen;
                this.street = formData.street;
                this.brgy = formData.brgy;
                this.city = formData.city;
                this.name = formData.name;
                this.address = formData.address;
            }
        },
        computed: {
            formattedDate() {
                if (this.requestDate) {
                    const [year, month, day] = this.requestDate.split('/');
                    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                }
                return '';
            },
        },

        methods: {
            closeAddDrawer() {
                this.$confirm('Are you sure you want to cancel adding new Admission?', {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                })
                .then(() => {
                    this.openAddDrawer = false
                })
                .catch(() => {});
            },
            resetFormData() {
                this.submitForm = []
            },
            getData() {
                axios.post("{{route('fetchStudent')}}")
                    .then(response => {
                        console.log(response.data);
                        if (response.data.error) {
                            this.tableData = [];
                            console.log(this.tableData);
                        } else {
                            this.tableData = response.data;
                            this.checkIdentification = response.data.map(res => res.identification);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            calculateAge(birthDay) {
                let dob = new Date(birthDay);
                let now = new Date();
                let lastDayOfMonth = new Date(dob.getFullYear(), dob.getMonth() + 1, 0).getDate();

                let birthYear = dob.getYear();
                let birthMonth = dob.getMonth();
                let birthDate = dob.getDate();

                let currentYear = now.getYear();
                let currentMonth = now.getMonth();
                let currentDate = now.getDate();

                let monthDiff = currentMonth - birthMonth;
                let dateDiff = currentDate - birthDate;
                let age = currentYear - birthYear;

                if (age > 1 && (monthDiff < 0 || (monthDiff == 0 && currentDate < birthDate))) {
                    let ageCount = age - 1
                    return ageCount + ` year${ageCount > 1 ? "s" : ""} old`
                } else if (age == 1 && (monthDiff < 0 || (monthDiff == 0 && currentDate < birthDate))) {
                    let ageCount = 11 - birthMonth + currentMonth
                    return ageCount + ` month${ageCount > 1 ? "s" : ""} old`
                } else if (age == 0 && monthDiff > 0 && currentDate >= birthDate) {
                    let ageCount = monthDiff
                    return ageCount + ` month${ageCount > 1 ? "s" : ""} old`
                } else if (age == 0 && monthDiff > 1 && currentDate < birthDate) {
                    let ageCount = monthDiff - 1
                    return ageCount + ` month${ageCount > 1 ? "s" : ""} old`
                } else if (age == 0 && monthDiff <= 1 && currentDate >= birthDate) {
                    let ageCount = dateDiff
                    return ageCount + ` day${ageCount > 1 ? "s" : ""} old`
                } else if (age == 0 && monthDiff <= 1 && currentDate < birthDate) {
                    let ageCount = lastDayOfMonth - birthDate + currentDate
                    return ageCount + ` day${ageCount > 1 ? "s" : ""} old`
                }


                return age + ` year${age > 1 ? "s" : ""} old`;
            },
            submitForm() {
                // Perform form submission logic here
                // You can access the form data through the data properties
                this.age = this.calculateAge(this.birthdate);
                const formData = {
                    identification: this.identification,
                    year: this.year,
                    course: this.course,
                    firstname: this.firstname,
                    midname: this.midname,
                    lastname: this.lastname,
                    gender: this.gender,
                    phone_number:this.phone_number,
                    birthdate: this.birthdate,
                    civil: this.civil,
                    citizen: this.citizen,
                    street: this.street,
                    brgy: this.brgy,
                    city: this.city,
                    name: this.firstname + ' ' + this.midname.substr(0, 1) + ' ' + this.lastname,
                    address: this.street + ' ' + this.brgy + ' ' + this.city,
                    age: this.age,

                    // Add other form fields here
                };
                // Example validation
                if (!this.identification) {
                    this.identificationError = "Identification No. is required";
                } else if (this.checkIdentification.includes(this.identification.trim())) {
                    this.identificationError = "Identification No. already exists!";
                } else {
                    this.identificationError = "";
                }
                if (!this.year) {
                    this.yearError = "Year level is required";
                } else {
                    this.yearError = "";
                }
                if (!this.phone_number) {
                    this.phoneError = "Phone No. is required";
                } else {
                    this.phoneError = "";
                }
                // Perform other validations for each field

                if (!this.firstname) {
                    this.firstnameError = "First Name is required";
                } else if (!/^[a-zA-Z\s]+$/.test(this.firstname)) {
                    this.firstnameError = "Invalid First Name format";
                } else {
                    this.firstnameError = "";
                }
                if (!/^[a-zA-Z\s]+$/.test(this.midname)) {
                    this.midnameError = "Invalid Middle Name format";
                } else {
                    this.midnameError = "";
                }
                if (!this.lastname) {
                    this.lastnameError = "Last Name is required";
                } else if (!/^[a-zA-Z\s]+$/.test(this.lastname)) {
                    this.lastnameError = "Invalid Last Name format";
                } else {
                    this.lastnameError = "";
                }
                if (!this.gender) {
                    this.genderError = "Gender is required";
                } else {
                    this.genderError = "";
                }
                if (!this.birthdate) {
                    this.birthdateError = "Date of Birth is required";
                } else {
                    this.birthdateError = "";
                }
                if (!this.civil) {
                    this.civilError = "Civil Status is required";
                } else {
                    this.civilError = "";
                }
                if (!this.citizen) {
                    this.citizenError = "Citizenship is required";
                } else {
                    this.citizenError = "";
                }
                if (!this.street) {
                    this.streetError = "Street Address and Street no. is required";
                } else {
                    this.streetError = "";
                }
                if (!this.brgy) {
                    this.brgyError = "Barangay is required";
                } else {
                    this.brgyError = "";
                }
                if (!this.city) {
                    this.cityError = "Municipality/City is required";
                } else {
                    this.cityError = "";
                }

                // Check if all fields are valid and proceed with form submission if they are

                if (
                    !this.identificationError &&
                    !this.yearError &&
                    !this.firstnameError &&
                    // !this.midnameError &&
                    !this.lastnameError &&
                    !this.genderError &&
                    !this.birthdateError &&
                    !this.civilError &&
                    !this.citizenError &&
                    !this.streetError &&
                    !this.brgyError &&
                    !this.cityError
                ) {
                    // All fields are valid, perform form submission logic here
                    console.log("Form submitted");
                    this.active++;
                    localStorage.setItem("active", this.active)
                    localStorage.setItem("formData", JSON.stringify(formData));
                    this.isCBC = false;
                    this.isUrinalysis = false;
                    this.isFecalysis = false;
                    this.isXray = false;
                    this.isAntigen = false;
                    this.isVaccine = false;

                    localStorage.setItem("age", this.age);
                } else {
                    this.$message.error("Cannot submit the form. Please check the error(s).")
                    return false;
                }
            },
            back() {
                if (this.active == 1) {
                    if (this.formData && Object.values(this.formData).every((i) => i == "")) {
                        this.formData = {};
                    }
                    if (this.formData && Object.values(this.formData).length != 0) {
                        this.$confirm('There are unsaved changes. Continue?', {
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No',
                            })
                            .then((result) => {
                                if (result.value) {
                                    this.active--;
                                    this.formData = {};
                                    localStorage.removeItem('active');
                                    localStorage.removeItem('formData'); // Remove the saved form data
                                }
                            })
                            .catch(() => {});
                    } else {
                        this.active--;
                        localStorage.removeItem('active');
                        localStorage.removeItem('formData'); // Remove the saved form data
                    }
                } else if (this.active == 2) {
                    if (this.formData && Object.values(this.formData).every((i) => i == "")) {
                        this.formData = {};
                    }
                    if (this.formData && Object.values(this.formData).length != 0) {
                        this.$confirm('There are unsaved changes. Continue?', {
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No',
                            })
                            .then((result) => {
                                if (result.value) {
                                    this.active--;
                                    this.formData = {};
                                    localStorage.removeItem('formData');
                                    localStorage.removeItem('age');
                                    localStorage.setItem('active', this.active);
                                }
                            })
                            .catch(() => {});
                    } else {
                        this.active--;
                        localStorage.removeItem('age');
                        localStorage.setItem('active', this.active);
                    }
                } else {
                    this.active--;
                }
            },
            next() {
                if (this.isCBC || this.isUrinalysis || this.isFecalysis || this.isXray || this.isAntigen || this.isVaccine) {
                    if (this.isCBC) {
                        localStorage.setItem("isCBC", this.isCBC)
                        window.location.href = '{{route("cbcForm")}}';
                    } else if (this.isUrinalysis) {
                        localStorage.setItem("isUrinalysis", this.isUrinalysis)
                        window.location.href = '{{route("urinalysisForm")}}';
                    } else if (this.isFecalysis) {
                        localStorage.setItem("isFecalysis", this.isFecalysis)
                        window.location.href = '{{route("fecalysisForm")}}';
                    } else if (this.isXray) {
                        localStorage.setItem("isXray", this.isXray)
                        window.location.href = '{{route("xrayForm")}}';
                    } else if (this.isAntigen) {
                        localStorage.setItem("isAntigen", this.isAntigen)
                        window.location.href = '{{route("antigenForm")}}';
                    } else if (this.isVaccine) {
                        localStorage.setItem("isVaccine", this.isVaccine)
                        window.location.href = '{{route("vaccineForm")}}';
                    }
                } else {
                    this.$message.error("Please select an appointment!");
                    return false;
                }

            },
            cbc() {
                this.isCBC = !this.isCBC;
                this.isUrinalysis = false;
                this.isFecalysis = false;
                this.isXray = false;
                this.isAntigen = false;
                this.isVaccine = false;
            },
            urinalysis() {
                this.isCBC = false;
                this.isUrinalysis = !this.isUrinalysis;
                this.isFecalysis = false;
                this.isXray = false;
                this.isAntigen = false;
                this.isVaccine = false;
            },
            fecalysis() {
                this.isCBC = false;
                this.isUrinalysis = false;
                this.isFecalysis = !this.isFecalysis;
                this.isXray = false;
                this.isAntigen = false;
                this.isVaccine = false;
            },
            xray() {
                this.isCBC = false;
                this.isUrinalysis = false;
                this.isFecalysis = false;
                this.isXray = !this.isXray;
                this.isAntigen = false;
                this.isVaccine = false;
            },
            antigen() {
                this.isCBC = false;
                this.isUrinalysis = false;
                this.isFecalysis = false;
                this.isXray = false;
                this.isAntigen = !this.isAntigen;
                this.isVaccine = false;
            },
            vaccine() {
                this.isCBC = false;
                this.isUrinalysis = false;
                this.isFecalysis = false;
                this.isXray = false;
                this.isAntigen = false;
                this.isVaccine = !this.isVaccine;
            },
        },
    });
    window.addDashes = function addDashes(f) {
        // Remove any non-alphanumeric characters
        var alphanumericOnly = f.value.replace(/\W/g, '');

        // Extract the first two characters and the next four characters
        var cc = alphanumericOnly.substr(0, 2).toUpperCase();
        var num = alphanumericOnly.substr(2, 4);

        // Set the value of the input field with the pattern "CC-0001"
        f.value = cc + '-' + num;
    }

    window.upperCase = function upperCase(input) {
        // Get the current value of the input field
        var value = input.value;

        // Convert only the first character to uppercase
        var convertedValue = value.charAt(0).toUpperCase() + value.slice(1);

        // Set the modified value back to the input field
        input.value = convertedValue;
    }
</script>