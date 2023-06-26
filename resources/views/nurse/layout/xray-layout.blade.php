@include('nurse/imports/head')
<title>@yield('title')</title>
<div id="app">
    <div v-if="fullscreenLoading" class="fullscreen-loading">
        <div class="spinner-heart" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="spinner-text">Loading...</span>
    </div>
    @include('nurse/imports/nav')
    @yield('header')
</div>
@yield('content')
@include('nurse/imports/body')
<script>
    // ELEMENT.locale(ELEMENT.lang.en)
    new Vue({
        el: '#app',
        data() {
            return {
                maxDate: new Date().toISOString().split("T")[0],
                fullscreenLoading: true,
                active: 0,
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
                // cbc
                errors: {},
                case_No: "",
                referred_by: "",
                room_bed: "",
                clinical_impression: "",
                type_examination: "",
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
            console.log(formData)
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
            back() {
                this.$confirm('There are unsaved changes. Continue?', 'Confirmation', {
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                type: 'warning'
                })
                .then(() => {
                    // Perform the desired actions when confirmed
                    this.fullscreenLoading = true;
                    this.active--;
                    this.formData = {};
                    localStorage.removeItem('active');
                    localStorage.removeItem('formData'); // Remove the saved form data

                    // Redirect to the desired location after a delay
                    setTimeout(() => {
                        this.fullscreenLoading = false;
                        window.location.href = "{{route('nurse-admission')}}";
                    }, 2000);
                })
                .catch(() => {
                    // Handle the rejection or cancelation
                    // (No action needed in this case)
                });
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
            submitXray() {
                const storedFormData = localStorage.getItem("formData");
                const formData = storedFormData ? JSON.parse(storedFormData) : {};
                this.age = localStorage.getItem("age") || "";

                // Reset validation errors
                this.errors = {};

                // Perform validation
                if (this.case_No.trim() === "") {
                    this.errors.case_No = "Please enter the Case No.";
                }
                if (this.referred_by.trim() === "") {
                    this.errors.referred_by = "Please enter the Referred By.";
                }
                if (this.room_bed.trim() === "") {
                    this.errors.room_bed = "Please enter the Room/Bed.";
                }
                if (this.clinical_impression.trim() === "") {
                    this.errors.clinical_impression = "Please enter the Clinical Impression.";
                }
                if (this.type_examination.trim() === "") {
                    this.errors.type_examination = "Please enter the Type of Examination.";
                }
                // Add more validation rules for other form fields

                if (Object.keys(this.errors).length > 0) {
                    // Handle validation errors, e.g., display an error message
                    return false; // Indicates that the form is not valid
                }

                // Form is valid, perform Axios POST request
                var newData = new FormData()
                // Append form data from local storage
                Object.entries(formData).forEach(([key, value]) => {
                    newData.append(key, value);
                });
                newData.append('age', this.age)
                newData.append('case_No', this.case_No)
                newData.append('referred_by', this.referred_by)
                newData.append('room_bed', this.room_bed)
                newData.append('clinical_impression', this.clinical_impression)
                newData.append('type_examination', this.type_examination)
                console.log(newData);
                axios.post("{{ route('storeXray') }}", newData)
                    .then(response => {
                        // Handle success response
                        console.log(response.data);
                        setTimeout(() => {
                            this.$message({
                                message: 'New X-ray form has been added successfully!',
                                type: 'success'
                            });
                            localStorage.removeItem("active", this.active)
                            localStorage.removeItem("formData", this.formData)
                            this.openAddDrawer = false;
                            this.fullscreenLoading = true;
                            this.active == 0;
                            this.getData()
                            setTimeout(() => {
                                // this.openAddDialog = true;
                                this.fullscreenLoading = false;
                                window.location.href="{{route('nurse-admission')}}";
                            }, 1000)
                        }, 1500);
                        this.resetFormData();
                        return true; // Indicates successful form submission
                    })
                    .catch(error => {
                        // Handle error response
                        console.error(error.response.data);
                        this.$message.error("Cannot submit the form. Please check the error(s).")
                        return false;
                    });
            },
            resetFormData() {
                this.submitCBC = []
            },
            logout() {
                this.fullscreenLoading = true
                axios.post("{{route('nurse-logout')}}")
                .then(response => {
                    // console.log(response);
                    if (response.data.message) {
                        localStorage.clear();
                        this.$notify({
                            title: 'Success',
                            message: 'Successfully logged out!',
                            type: 'success',
                            showClose: false
                        });
                        setTimeout(() => {
                            window.location.href = "{{route('student-login')}}"
                        }, 1000)
                    }
                })
            }
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