@include('admin/imports/head')
<title>@yield('title')</title>
<div id="app">
    <div v-if="fullscreenLoading" class="fullscreen-loading">
        <div class="spinner-heart" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="spinner-text">Loading...</span>
    </div>
    @include('admin/imports/nav')
    @yield('header')
    <!-- sidebar -->
    <div class="container-fluid page-wrapper">
        @include('admin/imports/sidebar')
        @yield('sidebar')
    </div>
</div>
@include('admin/imports/body')

<script>
    // Vue.use(ElementUI, { locale: 'en' });
    // console.log(Vue);
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            const validateAddID = (rule, value, callback) => {
                if (this.checkIdentification.includes(value.trim())) {
                    callback(new Error('Email address already exist!'));
                } else {
                    callback();
                }
            };
            const validateUpdateID = (rule, value, callback) => {
                if (localStorage.getItem("email") != value) {
                    if (this.checkIdentification.includes(value.trim())) {
                        callback(new Error('Email address already exist!'));
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
                viewTeacher: [],
                newUser: [],
                showAllData: false,
                searchValue: "",
                searchNull: "",
                searchName: "",
                searchID: "",
                searchContact: "",
                options: [{
                    value: 'email',
                    label: 'Email Address.'
                }, {
                    value: 'name',
                    label: 'Name'
                }, {
                    value: 'status',
                    label: 'Status'
                }],
                tableData: [],
                status: true,
                tableLoad: false,
                openAddDialog: false,
                openAddDrawer: false,
                checkIdentification: [],
                addTeacher: {
                    email: "",
                    firstname: "",
                    midname: "",
                    lastname: "",
                    gender: "",
                    phone_number: "",
                    birthdate: "",
                },
                rules: {
                    email: [{
                            required: true,
                            message: "Email Address is required!",
                            trigger: "blur",
                        },
                        {
                            validator: validateAddID,
                            trigger: 'blur'
                        },
                        {
                            pattern: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
                            message: "Invalid Email Address format!",
                            trigger: "blur",
                        },
                    ],
                    firstname: [{
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
                    midname: [{
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
                    lastname: [{
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
                    gender: [{
                        required: true,
                        message: "Gender is required!",
                        trigger: "blur",
                    }, ],
                    phone_number: [{
                        required: true,
                        message: "Phone number is required!",
                        trigger: "blur",
                    }, ],
                },
                editTeacher: [],
                updateTeacher: {
                    id: 0,
                    email: "",
                    firstname: "",
                    midname: "",
                    lastname: "",
                    gender: "",
                    phone_number: "",
                    birthdate: "",
                },
                editRules: {
                    email: [{
                        required: true,
                        message: "Email Address is required!",
                        trigger: "blur",
                    }, {
                        validator: validateUpdateID,
                        trigger: 'blur'
                    }],
                    firstname: [{
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
                    midname: [{
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
                    lastname: [{
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
                    gender: [{
                        required: true,
                        message: "Gender is required!",
                        trigger: "blur",
                    }, ],
                    phone_number: [{
                        required: true,
                        message: "Phone number is required!",
                        trigger: "blur",
                    }, ],
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
        },
        watch: {
            editTeacher(value) {
                this.updateTeacher.id = value.id ? value.id : "";
                this.updateTeacher.email = value.email ? value.email : "";
                this.updateTeacher.firstname = value.firstname ? value.firstname : "";
                this.updateTeacher.midname = value.midname ? value.midname : "";
                this.updateTeacher.lastname = value.lastname ? value.lastname : "";
                this.updateTeacher.birthdate = value.birthdate ? value.birthdate : "";
                this.updateTeacher.phone_number = value.phone_number ? value.phone_number : "";
                this.updateTeacher.gender = value.gender ? value.gender : "";
            },
            searchValue(value) {
                if (value == "" || value == "email" || value == "name" || value == "status") {
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
                    .filter((data) => {
                        return data.email.toLowerCase().includes(this.searchID.toLowerCase());
                    })
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
                this.viewTeacher = row;
                this.viewDialog = true;
            },
            closeViewDialog() {
                this.viewDialog = false;
            },
            closeEditDialog(editTeacher) {
                this.$confirm('Are you sure you want to cancel updating Teacher?', {
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    })
                    .then(() => {
                        this.editDialog = false
                        this.$refs[editTeacher].resetFields();
                        localStorage.removeItem("email")
                        localStorage.clear()
                    })
                    .catch(() => {});
            },
            closeAddDialog() {
                this.$confirm('Done copying username & password?', 'Warning', {
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        type: "warning"
                    })
                    .then(() => {
                        this.openAddDialog = false
                    })
                    .catch(() => {});
            },
            handleEdit(index, row) {
                localStorage.setItem("email", row.email)
                this.editTeacher = {
                    id: row.id,
                    email: row.email,
                    firstname: row.firstname,
                    midname: row.midname,
                    lastname: row.lastname,
                    birthdate: row.birthdate,
                    gender: row.gender,
                    phone_number: row.phone_number,
                }
                this.editDialog = true;
            },
            closeAddDrawer() {
                this.$confirm('Are you sure you want to cancel adding new Admission?', {
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    })
                    .then(() => {
                        this.openAddDrawer = false
                        this.$refs[addTeacher].resetFields();
                    })
                    .catch(() => {});
            },
            resetFormData() {
                this.submitForm = []
            },
            getData() {
                axios.post("{{ route('teacherFetch') }}")
                    .then(response => {
                        console.log(response.data);
                        if (response.data.error) {
                            this.tableData = [];
                            this.tableDataErr = response.data.error;
                            console.log(this.tableDataErr);
                        } else {
                            this.tableData = response.data;
                            this.checkIdentification = response.data.map(res => res.email);
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
            addUser(addTeacher) {
                this.$refs[addTeacher].validate((valid) => {
                    if (valid) {
                        this.loadButton = true;
                        this.openAddDrawer = false;
                        const birthday = this.addTeacher.birthdate;
                        const birthdayFormat = birthday.getFullYear() + "-" + ((birthday.getMonth() +
                            1) > 9 ? '' : '0') + (birthday.getMonth() + 1) + "-" + (birthday
                            .getDate() > 9 ? '' : '0') + birthday.getDate();
                        var newData = new FormData()
                        newData.append("email", this.addTeacher.email)
                        newData.append("firstname", this.addTeacher.firstname)
                        newData.append("midname", this.addTeacher.midname)
                        newData.append("lastname", this.addTeacher.lastname)
                        newData.append("gender", this.addTeacher.gender)
                        newData.append("phone_number", this.addTeacher.phone_number)
                        newData.append("birthdate", birthdayFormat)
                        axios.post("{{ route('storeTeacher') }}", newData)
                            .then(response => {
                                console.log(response);
                                if (response.data) {
                                    this.tableLoad = true;
                                    setTimeout(() => {
                                        this.$message({
                                            message: 'New Teacher Account has been added successfully!',
                                            type: 'success'
                                        });
                                        this.getData();
                                        this.tableLoad = false;
                                        setTimeout(() => {
                                            this.openAddDialog = true;
                                        }, 1500)
                                    }, 1500);
                                    this.resetFormData();
                                    this.newUser = response.data;
                                    this.loadButton = false;
                                }
                            })
                            .catch(error => {
                                console.error(error.response.data);
                            });
                    } else {
                        this.$message.error("Cannot submit the form. Please check the error(s).")
                        return false;
                    }
                });
            },
            resetForm(addTeacher) {
                this.$refs[addTeacher].resetFields();
            },
            resetFormData() {
                this.addTeacher = []
            },
            updateUser(updateTeacher) {
                this.$refs[updateTeacher].validate((valid) => {
                    if (valid) {
                        if (this.editTeacher.email != this.updateTeacher.email || this.editTeacher
                            .firstname != this.updateTeacher.firstname || this.editTeacher.midname !=
                            this.updateTeacher.midname || this.editTeacher.lastname != this
                            .updateTeacher.lastname || this.editTeacher.birthdate != this.updateTeacher
                            .birthdate || this.editTeacher.gender != this.updateTeacher.gender || this
                            .editTeacher.phone_number != this.updateTeacher.phone_number) {
                            this.loadButton = true;
                            this.$confirm('This will update user ' + this.editTeacher.firstname +
                                    '. Continue?', {
                                        confirmButtonText: 'Confirm',
                                        cancelButtonText: 'Cancel',
                                    })
                                .then(() => {
                                    const birthday = new Date(Date.parse(this.updateTeacher
                                        .birthdate));
                                    const birthdayFormat = birthday.getFullYear() + "-" + ((birthday
                                        .getMonth() + 1) > 9 ? '' : '0') + (birthday
                                        .getMonth() + 1) + "-" + (birthday.getDate() > 9 ? '' :
                                        '0') + birthday.getDate();
                                    this.editDialog = false;
                                    var updateData = new FormData()
                                    updateData.append("id", this.updateTeacher.id)
                                    updateData.append("email", this.updateTeacher.email)
                                    updateData.append("firstname", this.updateTeacher.firstname)
                                    updateData.append("midname", this.updateTeacher.midname)
                                    updateData.append("lastname", this.updateTeacher.lastname)
                                    updateData.append("birthdate", birthdayFormat)
                                    updateData.append("gender", this.updateTeacher.gender)
                                    updateData.append("phone_number", this.updateTeacher
                                        .phone_number)
                                    axios.post("{{ route('teacherUpdate') }}", updateData)
                                        .then(response => {
                                            if (response.data) {
                                                this.loadButton = false;
                                                this.tableLoad = true;
                                                this.getData();
                                                setTimeout(() => {
                                                    this.tableLoad = false;
                                                    this.$message({
                                                        message: 'Teacher Data has been updated successfully!',
                                                        type: 'success'
                                                    });
                                                }, 1500)
                                            } else {
                                                console.log(response.data.error);
                                            }
                                        })
                                    localStorage.removeItem("email")
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
                                    localStorage.removeItem("email")
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
                axios.post("{{ route('nurseStatus') }}", updateStatus)
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
