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
                fullscreenLoading: true,
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
                checkIdentification: [],
                editStudent: [],
                updateStudent: {
                    id: 0,
                    identification: "",
                    year: "",
                    classSection: "",
                    course: "Nursing",
                    firstname: "",
                    midname: "",
                    lastname: "",
                    gender: "",
                    phone_number:"",
                    birthdate: "",
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

            this.age = localStorage.age ? localStorage.age : 0
        },
            watch: {
                editStudent(value) {
                    this.updateStudent.id = value.id ? value.id : "";
                    this.updateStudent.identification = value.identification ? value.identification : "";
                    this.updateStudent.firstname = value.firstname ? value.firstname : "";
                    this.updateStudent.midname = value.midname ? value.midname : "";
                    this.updateStudent.lastname = value.lastname ? value.lastname : "";
                    this.updateStudent.birthdate = value.birthdate ? value.birthdate : "";
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
                        .filter((data) => {
                            return data.identification.toLowerCase().includes(this.searchID.toLowerCase());
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
                    this.$refs[addStudent].resetFields();
                    this.openAddDrawer = false
                })
                .catch(() => {});
            },
            resetFormData() {
                this.submitForm = []
            },
            getData() {
                axios.post("{{route('fetchVaccine')}}")
                    .then(response => {
                        console.log(response.data);
                        if (response.data.error) {
                            this.tableData = [];
                        } else {
                            this.tableData = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
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
            updateUser(updateStudent) {
                    this.$refs[updateStudent].validate((valid) => {
                        if (valid) {
                            if (this.editStudent.identification != this.updateStudent.identification || this.editStudent.year != this.updateStudent.year|| this.editStudent.classSection != this.updateStudent.classSection|| this.editStudent.firstname != this.updateStudent.firstname || this.editStudent.midname != this.updateStudent.midname || this.editStudent.lastname != this.updateStudent.lastname || this.editStudent.birthdate != this.updateStudent.birthdate || this.editStudent.gender != this.updateStudent.gender|| this.editStudent.phone_number != this.updateStudent.phone_number ) {
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