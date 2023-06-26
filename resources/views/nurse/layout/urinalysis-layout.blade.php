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
                // cbc
                errors: {},
                requestDate: "",
                color: "",
                transparency: "",
                gravity: "",
                ph: "",
                sugar:"",
                protein:"",
                pregnancy:"",
                pus: "",
                rbc: "",
                cast: "",
                urates: "",
                uric: "",
                cal: "",
                epith: "",
                mucus: "",
                otherOthers:"",
                pathologist: "",
                technologist: "",
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
            submitUrinalysis() {
                const storedFormData = localStorage.getItem("formData");
                const formData = storedFormData ? JSON.parse(storedFormData) : {};
                this.age = localStorage.getItem("age") || "";

                // Reset validation errors
                this.errors = {};
                if (this.requestDate.trim() === "") {
                this.errors.requestDate = "Please enter the date.";
                }
                if (this.color.trim() === "") {
                this.errors.color = "Please enter the color.";
                }
                if (this.transparency.trim() === "") {
                this.errors.transparency = "Please enter the transparency.";
                }
                if (this.gravity.trim() === "") {
                this.errors.gravity = "Please enter the specific gravity.";
                }
                if (this.ph.trim() === "") {
                this.errors.ph = "Please enter pH.";
                }
                if (this.sugar.trim() === "") {
                    this.errors.sugar = "Please enter the sugar.";
                }
                if (this.protein.trim() === "") {
                    this.errors.protein = "Please enter the protein.";
                }
                if (this.pregnancy.trim() === "") {
                    this.errors.pregnancy = "Please enter the pregnancy.";
                }
                if (this.pus.trim() === "") {
                this.errors.pus = "Please enter the pus cells.";
                }
                if (this.cast.trim() === "") {
                    this.errors.cast = "Please enter the cast.";
                }
                if (this.urates.trim() === "") {
                    this.errors.urates = "Please enter the urates.";
                }
                if (this.uric.trim() === "") {
                    this.errors.uric = "Please enter the uric acid.";
                }
                if (this.cal.trim() === "") {
                    this.errors.cal = "Please enter the calcium.";
                }
                if (this.epith.trim() === "") {
                    this.errors.epith = "Please enter the epithelial cells.";
                }
                if (this.mucus.trim() === "") {
                    this.errors.mucus = "Please enter the mucus.";
                }
                if (this.otherOthers.trim() === "") {
                    this.errors.otherOthers = "Please enter other details.";
                }
                if (this.pathologist.trim() === "") {
                this.errors.pathologist = "Please enter the pathologist.";
                }
                if (this.technologist.trim() === "") {
                this.errors.technologist = "Please enter the medical technologist.";
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
                newData.append('requestDate', this.requestDate);
                newData.append('color', this.color);
                newData.append('transparency', this.transparency);
                newData.append('gravity', this.gravity);
                newData.append('ph', this.ph);
                newData.append('sugar', this.sugar);
                newData.append('protein', this.protein);
                newData.append('pregnancy', this.pregnancy);
                newData.append('pus', this.pus);
                newData.append('rbc', this.rbc);
                newData.append('cast', this.cast);
                newData.append('urates', this.urates);
                newData.append('uric', this.uric);
                newData.append('cal', this.cal);
                newData.append('epith', this.epith);
                newData.append('mucus', this.mucus);
                newData.append('otherOthers', this.otherOthers);
                newData.append('pathologist', this.pathologist);
                newData.append('technologist', this.technologist);
                axios.post("{{ route('storeUrinalysis') }}", newData)
                    .then(response => {
                        // Handle success response
                        console.log(response.data);
                        setTimeout(() => {
                            this.$message({
                                message: 'New Urinalysis form has been added successfully!',
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