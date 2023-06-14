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
    <!-- sidebar -->
    <div class="container-fluid page-wrapper">
@include('nurse/imports/sidebar')
        @yield('sidebar')
    </div>
</div>
@include('nurse/imports/body')

<script>
    // Vue.use(ElementUI, { locale: 'en' });
    // console.log(Vue);
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            const validateAddID = (rule, value, callback) => {
                if (this.checkIdentification.includes(value.trim())) {
                    callback(new Error('Identification no. already exist!'));
                } else {
                    callback();
                }
            };
            const validateUpdateID = (rule, value, callback) => {
                if (localStorage.getItem("identification") != value) {
                    if (this.checkIdentification.includes(value.trim())) {
                        callback(new Error('Identification no. already exist!'));
                    } else {
                        callback();
                    }
                } else {
                    callback();
                }
            };
            const validateBirthdate = (rule, value, callback) => {
                var today = new Date();
                var birthDate = new Date(value);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                if (age < 18) {
                    callback(new Error('Age should atleast eightteen(18)!'));
                } else {
                    callback();
                }
            };
            return {
                birthdayOptions: {
                    disabledDate(date) {
                        return date > new Date()
                    }
                },
                maxDate: new Date().toISOString().split("T")[0],
                fullscreenLoading: true,
                active: 0,
                page: 1,
                pageSize: 10,
                topLabel: "top",
                leftLabel: "left",
                direction: 'btt',
                loadButton: false,
                editDialog: false,
                viewDialog: false,
                viewStudent: [],
                status: true,
                switch: false,
                showAllData: false,
                    searchValue: "",
                    searchNull: "",
                    searchName: "",
                    searchID: "",
                    searchContact: "",
                    options: [{
                        value: 'identification',
                        label: 'Identifiaction No.'
                    }, {
                        value: 'name',
                        label: 'Name'
                    }, {
                        value: 'status',
                        label: 'Status'
                    }],
                tableData: [],
                tableLoad: false,
                openAddDialog: false,
                openAddDrawer: false,
                status:true,
                tableLoad: false,
                openAddDialog: false,
                openAddDrawer: false,
                isCBC: false,
                isUrinalysis: false,
                isFecalysis: false,
                isXray: false,
                isAntigen: false,
                isVaccine: false,
                identification: "",
                password: "",
                year: "",
                classSection: "",
                firstname: "",
                midname: "",
                lastname: "",
                gender: "",
                phone_number:"",
                status: "",
                birthdate: "",
                height: "",
                weight: "",
                civil: "",
                citizen: "",
                street: "",
                brgy: "",
                city: "",
                identificationError: "",
                yearError: "",
                classSectionError: "",
                firstnameError: "",
                midnameError: "",
                lastnameError: "",
                genderError: "",
                phoneError:"",
                birthdateError: "",
                heightError: "",
                weightError: "",
                civilError: "",
                citizenError: "",
                streetError: "",
                brgyError: "",
                cityError: "",
                checkIdentification: [],
                addAdmission: {
                    identification: "",
                    year: "",
                    classSection: "",
                    firstname: "",
                    midname: "",
                    lastname: "",
                    phone_number:"",
                    gender: "",
                    birthdate: "",
                    height: "",
                    weight: "",
                    civil: "",
                    citizen: "",
                    street: "",
                    brgy: "",
                    city: "",
                },
                editStudent: [],
                updateStudent: {
                    id: 0,
                    identification: "",
                    year: "",
                    classSection: "",
                    firstname: "",
                    midname: "",
                    lastname: "",
                    gender: "",
                    phone_number:"",
                    birthdate: "",
                    height: "",
                    weight: "",
                },
                year: [
                    {
                        value: "First Year",
                        label: "First Year",
                    },
                    {
                        value: "Second Year",
                        label: "Second Year",
                    },
                    {
                        value: "Third Year",
                        label: "Third Year",
                    },
                    {
                        value: "Fourth Year",
                        label: "Fourth Year",
                    },
                ],
                classSection: [
                    {
                        value: "A",
                        label: "A",
                    },
                    {
                        value: "B",
                        label: "B",
                    },
                    {
                        year: "C",
                        label: "C",
                    },
                ],
                    editRules: {
                        identification: [
                            {
                            required: true,
                            message: "Identification no. is required!",
                            trigger: "blur",
                            }, {
                            validator: validateBirthdate,
                            trigger: 'blur'
                            }
                        ],
                        year: [
                            {
                            required: true,
                            message: "Year Level is required!",
                            trigger: "blur",
                            },
                        ],
                        classSection: [
                            {
                            required: true,
                            message: "Class Section is required!",
                            trigger: "blur",
                            },
                        ],
                        firstname: [
                            {
                            required: true,
                            message: "First name is required!",
                            trigger: "blur",
                            },
                            {
                            pattern: /^[a-zA-Z ]*$/,
                            message: "Invalid first name format!",
                            trigger: "blur",
                            },
                            {
                            min: 2,
                            message: "First name should be at least two(2) characters!",
                            trigger: "blur",
                            },
                        ],
                        midname: [
                            {
                            pattern: /^[a-zA-Z- ]*$/,
                            message: "Invalid last name format!",
                            trigger: "blur",
                            },
                            {
                            min: 2,
                            message: "Last name should be at least two(2) characters!",
                            trigger: "blur",
                            },
                        ],
                        lastname: [
                            {
                            required: true,
                            message: "Last name is required!",
                            trigger: "blur",
                            },
                            {
                            pattern: /^[a-zA-Z- ]*$/,
                            message: "Invalid last name format!",
                            trigger: "blur",
                            },
                            {
                            min: 2,
                            message: "Last name should be at least two(2) characters!",
                            trigger: "blur",
                            },
                        ],
                        birthdate: [{
                            required: true,
                            message: 'Birthday is required!',
                            trigger: 'blur'
                        }, {
                            validator: validateBirthdate,
                            trigger: 'blur'
                        }],
                        height: [{
                            required: true,
                            message: 'Height is required!',
                            trigger: 'blur'
                            },
                        ],
                        weight: [{
                            required: true,
                            message: 'Weight is required!',
                            trigger: 'blur'
                            }, 
                        ],
                        gender: [
                            {
                            required: true,
                            message: "Gender is required!",
                            trigger: "blur",
                            },
                        ],
                        phone_number: [
                            {
                            required: true,
                            message: "Phone number is required!",
                            trigger: "blur",
                            },
                        ],
                    },
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
                this.classSection = formData.classSection;
                this.firstname = formData.firstname;
                this.midname = formData.midname;
                this.lastname = formData.lastname;
                this.gender = formData.gender;
                this.phone_number = formData.phone_number;
                this.birthdate = formData.birthdate;
                this.height = formData.height;
                this.weight = formData.weight;
                this.civil = formData.civil;
                this.citizen = formData.citizen;
                this.street = formData.street;
                this.brgy = formData.brgy;
                this.city = formData.city;
                this.name = formData.name;
                this.address = formData.address;
            }
        },
            watch: {
                editStudent(value) {
                    this.updateStudent.id = value.id ? value.id : "";
                    this.updateStudent.identification = value.identification ? value.identification : "";
                    this.updateStudent.firstname = value.firstname ? value.firstname : "";
                    this.updateStudent.midname = value.midname ? value.midname : "";
                    this.updateStudent.lastname = value.lastname ? value.lastname : "";
                    this.updateStudent.birthdate = value.birthdate ? value.birthdate : "";
                    this.updateStudent.height = value.height ? value.height : "";
                    this.updateStudent.weight = value.weight ? value.weight : "";
                    this.updateStudent.gender = value.gender ? value.gender : "";
                    this.updateStudent.year = value.year ? value.year : "";
                    this.updateStudent.classSection = value.classSection ? value.classSection : "";
                    this.updateStudent.phone_number = value.phone_number ? value.phone_number : "";
                },
                searchValue(value) {
                    if (value == "" || value == "identification" || value == "name" || value == "status") {
                        this.searchNull = '';
                        this.searchID = '';
                        this.searchName = '';
                        this.searchContact = '';
                    }
                },
                showAllData(value) {
                    if (value == true) {
                        this.page = 1;
                        this.pageSize = this.tableData.length
                    } else {
                        this.pageSize = 10
                    }
                },
            },
        computed: {
            formattedDate() {
                if (this.requestDate) {
                    const [year, month, day] = this.requestDate.split('/');
                    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                }
                return '';
            },
                usersTable() {
                    return this.tableData
                        .filter((data) => {
                            return data.name.toLowerCase().includes(this.searchName.toLowerCase());
                        })
                        // .filter((data) => {
                        //     return data.identification.toLowerCase().includes(this.searchID.toLowerCase());
                        // })
                        .filter((data) => {
                            return data.status.toLowerCase().includes(this.searchContact.toLowerCase());
                        })
                        .slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
                }
        },

        methods: {
            changeColumn(selected) {
                this.searchNull = ""
                this.searchName = ""
                this.searchID = ""
                this.searchContact = ""
            },
            setPage(value) {
                this.page = value
            },
            handleSelectionChange(val) {
                this.multiID = Object.values(val).map(i => i.id)
            },
            filterHandler(value, row, column) {
                const property = column['property'];
                return row[property] === value;
            },
            handleView(index, row) {
                this.viewStudent = row;
                this.viewDialog = true;
            },
            closeViewDialog() {
                this.viewDialog = false;
            },
            closeEditDialog(editStudent) {
                this.$confirm('Are you sure you want to cancel updating Student?', {
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    })
                    .then(() => {
                        this.editDialog = false
                        this.$refs[editStudent].resetFields();
                        localStorage.removeItem("identification")
                    })
                    .catch(() => {});
            },
            handleEdit(index, row) {
                localStorage.setItem("identification", row.identification)
                this.editStudent = {
                    id: row.id,
                    identification: row.identification,
                    year: row.year,
                    classSection: row.classSection,
                    firstname: row.firstname,
                    midname: row.midname,
                    lastname: row.lastname,
                    birthdate: row.birthdate,
                    height: row.height,
                    weight: row.weight,
                    gender: row.gender,
                    phone_number: row.phone_number,
                }
                this.editDialog = true;
            },
            //wala ga close ang drawer
            closeAddDrawer() {
                this.$confirm('Are you sure you want to cancel adding new Admission?', {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                })
                .then(() => {
                    this.openAddDrawer = false
                    localStorage.removeItem("identification")
                })
                .catch(() => {});
            },
            resetForm(addAdmission) {
                this.$refs[addAdmission].resetFields();
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
                        } else {
                            this.tableData = response.data;
                            this.checkIdentification = response.data.map(res => res.identification);
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
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
                    classSection: this.classSection,
                    firstname: this.firstname,
                    midname: this.midname,
                    lastname: this.lastname,
                    gender: this.gender,
                    phone_number:this.phone_number,
                    birthdate: this.birthdate,
                    height: this.height,
                    weight: this.weight,
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
                if (!this.classSection) {
                    this.classSectionError = "Class Section is required";
                } else {
                    this.classSectionError = "";
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
                if (!this.height) {
                    this.heightError = "Height is required";
                } else {
                    this.heightError = "";
                }
                if (!this.weight) {
                    this.weightError = "Weight is required";
                } else {
                    this.weightError = "";
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
                    !this.classSectionError &&
                    !this.firstnameError &&
                    // !this.midnameError &&
                    !this.lastnameError &&
                    !this.genderError &&
                    !this.birthdateError &&
                    !this.heightError &&
                    !this.weightError &&
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
            updateUser(updateStudent) {
                    this.$refs[updateStudent].validate((valid) => {
                        if (valid) {
                            if (this.editStudent.identification != this.updateStudent.identification || this.editStudent.year != this.updateStudent.year|| this.editStudent.classSection != this.updateStudent.classSection|| this.editStudent.firstname != this.updateStudent.firstname || this.editStudent.midname != this.updateStudent.midname || this.editStudent.lastname != this.updateStudent.lastname || this.editStudent.birthdate != this.updateStudent.birthdate || this.editStudent.height != this.updateStudent.height || this.editStudent.weight != this.updateStudent.weight || this.editStudent.gender != this.updateStudent.gender|| this.editStudent.phone_number != this.updateStudent.phone_number ) {
                                this.loadButton = true;
                                this.$confirm('This will update user ' + this.editStudent.firstname + '. Continue?', {
                                        confirmButtonText: 'Confirm',
                                        cancelButtonText: 'Cancel',
                                    })
                                    .then(() => {
                                        const birthday = new Date(Date.parse(this.updateStudent.birthdate));
                                        const birthdayFormat = birthday.getFullYear() + "-" + ((birthday.getMonth() + 1) > 9 ? '' : '0') + (birthday.getMonth() + 1) + "-" + (birthday.getDate() > 9 ? '' : '0') + birthday.getDate();
                                        this.editDialog = false;
                                        var updateData = new FormData()
                                        updateData.append("id", this.updateStudent.id)
                                        updateData.append("identification", this.updateStudent.identification)
                                        updateData.append("year", this.updateStudent.year)
                                        updateData.append("classSection", this.updateStudent.classSection)
                                        updateData.append("firstname", this.updateStudent.firstname)
                                        updateData.append("midname", this.updateStudent.midname)
                                        updateData.append("lastname", this.updateStudent.lastname)
                                        updateData.append("birthdate", birthdayFormat)
                                        updateData.append("height", this.updateStudent.height)
                                        updateData.append("weight", this.updateStudent.weight)
                                        updateData.append("gender", this.updateStudent.gender)
                                        updateData.append("phone_number", this.updateStudent.phone_number)
                                        axios.post("{{route('studentUpdate')}}", updateData)
                                            .then(response => {
                                                if (response.data) {
                                                    this.loadButton = false;
                                                    this.tableLoad = true;
                                                    setTimeout(() => {
                                                        this.tableLoad = false;
                                                        this.getData();
                                                        this.$message({
                                                            message: 'Student Data has been updated successfully!',
                                                            type: 'success'
                                                        });
                                                    }, 1500)
                                                }else{
                                                    console.log(response.data.error);
                                                }
                                            })
                                        localStorage.removeItem("identification")
                                    })
                                    .catch(() => {
                                        this.loadButton = false;
                                    });
                            } else {
                                this.$confirm('No changes made. Cancel editing user?', {
                                        confirmButtonText: 'Yes',
                                        cancelButtonText: 'No',
                                    })
                                    .then(() => {
                                        this.editDialog = false
                                        localStorage.removeItem("identification")
                                    })
                                    .catch(() => {
                                        this.editDialog = true
                                    })
                            }
                        } else {
                            this.$message.error("Cannot submit the form. Please check the error(s).")
                            return false;
                        }
                    });
                },
                handleSwitch(row) {
                    var updateStatus = new FormData()
                    updateStatus.append("id", row.id)
                    updateStatus.append("status", row.status)
                    axios.post("{{route('studentStatus')}}", updateStatus)
                        .then(response => {
                            if (response.data) {
                                this.loadButton = false;
                                this.tableLoad = true;
                                setTimeout(() => {
                                    this.tableLoad = false;
                                    this.getData();
                                    if (response.data.status == "Inactive") {
                                        this.$message({
                                            message: 'User has been deactivated!',
                                            type: 'success'
                                        });
                                    } else {
                                        this.$message({
                                            message: 'User has been activated!',
                                            type: 'success'
                                        });
                                    }

                                }, 1500)
                            }
                        })
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