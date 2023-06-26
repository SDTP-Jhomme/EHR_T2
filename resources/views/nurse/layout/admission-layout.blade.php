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
                reportOptions: {
                    disabledDate(date) {
                        return date > new Date()
                    }
                },
                fullscreenLoading: true,
                dialogTableVisible: false,
                active: 0,
                page: 1,
                pageSize: 6,
                topLabel: "top",
                leftLabel: "left",
                direction: 'ltr',
                loadButton: false,
                editDialog: false,
                viewDialog: false,
                viewStudent: [],
                studentTable: false,
                status: true,
                switch: false,
                dateRange: [],
                excelErrors:true,
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
                resultDialog: false,
                openAddDrawer: false,
                fileImg:null,
                medStatus:"",
                med_Status:"",
                isCBC: false,
                isUrinalysis: false,
                isFecalysis: false,
                isXray: false,
                isAntigen: false,
                isVaccine: false,
                hasCBC: false,
                hasUrinalysis: [],
                hasFecalysis: [],
                hasXray: [],
                hasAntigen: [],
                hasVaccine: [],
                checkIdentification: [],
                fileResults: [],
                fileList: [],
                printing: false,
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
                    guardianFname: "",
                    guardianMname: "",
                    guardianLname: "",
                    guardianPhone_number: "",
                    citizen: "",
                    civil: "",
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
                civil: [
                    {
                        value: "Single",
                        label: "Single",
                    },
                    {
                        value: "Married",
                        label: "Married",
                    },
                    {
                        value: "Widowed",
                        label: "Widowed",
                    },
                    {
                        value: "Divorced",
                        label: "Divorced",
                    },
                ],
                citizen: [
                    {
                        value: "Filipino",
                        label: "Filipino",
                    },
                    {
                        value: "American",
                        label: "American",
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
                        citizen: [
                            {
                            required: true,
                            message: "Citizenship is required!",
                            trigger: "blur",
                            },
                        ],
                        civil: [
                            {
                            required: true,
                            message: "Civil Status is required!",
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
                    guardianName: [
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
                    guardianPhone_number: [
                        {
                        required: true,
                        message: "City is required!",
                        trigger: "blur",
                        },
                    ],
                    },
            };
        },
        created() {
            this.getData()
            this.fetch_Cbc()
            this.fetch_Antigen()
            this.fetch_Urinalysis()
            this.fetch_Xray()
            this.fetch_Fecalysis()
            this.fetch_Vaccine()
        },
        mounted() {
            this.getData();
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)

            this.age = localStorage.age ? localStorage.age : 0
        },
            watch: {
                'addStudent.birthdate': {
                    handler(newDate) {
                    const birthdayFormat = newDate.getFullYear() + "-" + ((newDate.getMonth() + 1) > 9 ? '' : '0') + (newDate.getMonth() + 1) + "-" + (newDate.getDate() > 9 ? '' : '0') + newDate.getDate();
                    const age = this.calculateAge(birthdayFormat);
                    localStorage.setItem("age", age);
                    },
                    deep: true
                },
                'updateStudent.birthdate': {
                    handler(newDate) {
                    const birthdayFormat = newDate.getFullYear() + "-" + ((newDate.getMonth() + 1) > 9 ? '' : '0') + (newDate.getMonth() + 1) + "-" + (newDate.getDate() > 9 ? '' : '0') + newDate.getDate();
                    const age = this.calculateAge(birthdayFormat);
                    localStorage.setItem("age", age);
                    },
                    deep: true
                },
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
                    this.updateStudent.civil = value.civil ? value.civil : "";
                    this.updateStudent.citizen = value.citizen ? value.citizen : "";
                    this.updateStudent.guardianFname = value.guardianFname ? value.guardianFname : "";
                    this.updateStudent.guardianMname = value.guardianMname ? value.guardianMname : "";
                    this.updateStudent.guardianLname = value.guardianLname ? value.guardianLname : "";
                    this.updateStudent.guardianPhone_number = value.guardianPhone_number ? value.guardianPhone_number : "";
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
                medStatus(value) {
                    this.med_Status = value.medStatus ? value.medStatus : "";
                }
            },
        computed: {
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
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
            },
            handleExceed(files, fileList) {
                this.$message.warning(`The limit is 3, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
            },
            beforeRemove(file, fileList) {
                return this.$confirm(`Cancel the transfert of ${ file.name } ?`);
            },
            printTable() {
                // Create a new table element
                const table = document.createElement("table");
                table.classList.add("table-responsive", "table-bordered");
                table.style.width = "100%"; // Set the table width to 100%


                // Create the table header
                const thead = document.createElement("thead");
                const headerRow = document.createElement("tr");

                const idHeader = document.createElement("th");
                idHeader.classList.add("col-2");
                idHeader.textContent = "Id No.";

                const nameHeader = document.createElement("th");
                nameHeader.classList.add("col-3");
                nameHeader.textContent = "Name";

                const genderHeader = document.createElement("th");
                genderHeader.classList.add("col-2");
                genderHeader.textContent = "Gender";

                const birthdateHeader = document.createElement("th");
                birthdateHeader.classList.add("col-2");
                birthdateHeader.textContent = "Birthdate";

                const yearHeader = document.createElement("th");
                yearHeader.classList.add("col-2");
                yearHeader.textContent = "Year";

                const sectionHeader = document.createElement("th");
                sectionHeader.classList.add("col-3");
                sectionHeader.textContent = "Section";

                headerRow.appendChild(idHeader);
                headerRow.appendChild(nameHeader);
                headerRow.appendChild(genderHeader);
                headerRow.appendChild(birthdateHeader);
                headerRow.appendChild(yearHeader);
                headerRow.appendChild(sectionHeader);
                thead.appendChild(headerRow);

                // Create the table body
                const tbody = document.createElement("tbody");
                this.tableData.forEach(user => {
                const row = document.createElement("tr");

                const idCell = document.createElement("td");
                idCell.classList.add("col-2");
                idCell.textContent = user.identification;

                const nameCell = document.createElement("td");
                nameCell.classList.add("col-3");
                nameCell.textContent = user.name;

                const genderCell = document.createElement("td");
                genderCell.classList.add("col-2");
                genderCell.textContent = user.gender;

                const birthdateCell = document.createElement("td");
                birthdateCell.classList.add("col-2");
                birthdateCell.textContent = user.birthdate;

                const yearCell = document.createElement("td");
                yearCell.classList.add("col-2");
                yearCell.textContent = user.year;

                const sectionCell = document.createElement("td");
                sectionCell.classList.add("col-3");
                sectionCell.textContent = user.classSection;

                row.appendChild(idCell);
                row.appendChild(nameCell);
                row.appendChild(genderCell);
                row.appendChild(birthdateCell);
                row.appendChild(yearCell);
                row.appendChild(sectionCell);
                tbody.appendChild(row);
                });

                table.appendChild(thead);
                table.appendChild(tbody);

                // Open a new window/tab and display the table
                const newWindow = window.open();
                newWindow.document.write(`
                <html>
                    <head>
                    <title>Students Total Registered</title>
                    <link rel="stylesheet" href="<?php echo asset('assets/css/style.css') ?>">
                    <link rel="stylesheet" href="<?php echo asset('assets/css/table.css') ?>">
                    <link rel="stylesheet" href="<?php echo asset('assets/css/laboratory.css') ?>">
                    <link rel="stylesheet" href="<?php echo asset('assets/css/bootstrap.min.css') ?>">
                    <link rel="stylesheet" href="<?php echo asset('assets/fontawesome/css/all.min.css') ?>">
                    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
                    <style>
                        @media print {
                        .print-table button {
                            display: none;
                        }
                        }
                    </style>
                    </head>
                    <body>
                        <div class="container-fluid d-flex justify-content-center mt-5">
                            ${table.outerHTML}
                        </div>
                    </body>
                </html>
                `);
                setTimeout(() => {
                    newWindow.print();
                }, 500)
            },
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
            handleResult(index, row) {
                localStorage.setItem("student_id", row.id)
                this.viewStudent = row;
                this.resultDialog = true;
                this.medStatus={
                    med_Status: row.medStatus,
                }
            },
            handleView(index, row) {
                this.viewStudent = row;
                this.viewDialog = true;
            },
            closeViewDialog() {
                this.viewDialog = false;
            },
            closeResultDialog() {
                this.$confirm('Are you sure you want to cancel adding medical results?', {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                })
                .then(() => {
                    if(this.active == 0){
                        localStorage.removeItem("student_id")
                        localStorage.removeItem("active")
                        localStorage.removeItem("isCBC")
                        localStorage.removeItem("isUrinalysis")
                        localStorage.removeItem("isFecalysis")
                        localStorage.removeItem("isXray")
                        localStorage.removeItem("isAntigen")
                        localStorage.removeItem("isVaccine")
                        localStorage.removeItem("age")
                        localStorage.removeItem("viewStudent")
                        this.resultDialog = false
                    }else{
                        this.active--;
                        localStorage.removeItem("student_id")
                        localStorage.removeItem("active")
                        localStorage.removeItem("isCBC")
                        localStorage.removeItem("isUrinalysis")
                        localStorage.removeItem("isFecalysis")
                        localStorage.removeItem("isXray")
                        localStorage.removeItem("isAntigen")
                        localStorage.removeItem("isVaccine")
                        localStorage.removeItem("age")
                        localStorage.removeItem("viewStudent")
                        this.resultDialog = false
                    }
                })
                .catch(() => {});
            },
            closeEditDialog(editStudent) {
                this.$confirm('Are you sure you want to cancel updating Student?', {
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    })
                    .then(() => {
                        localStorage.removeItem("identification")
                        this.editDialog = false
                        this.$refs[editStudent].resetFields();
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
                    guardianFname: row.guardianFname,
                    guardianMname: row.guardianMname,
                    guardianLname: row.guardianLname,
                    guardianPhone_number: row.guardianPhone_number,
                    civil: row.civil,
                    citizen: row.citizen,
                }
                this.editDialog = true;
            },
            closeAddDrawer() {
                this.$confirm('Are you sure you want to cancel adding new Admission?', {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                })
                .then(() => {
                    this.openAddDrawer = false;
                    this.$refs[addStudent].resetFields();
                })
                .catch(() => {});
            },
            resetFormData() {
                this.submitForm = []
            },
            fetch_Cbc() {
                axios.post("{{route('fetchCbc')}}")
                    .then(response => {
                        if (response) {
                            this.hasCBC = response.data;
                        console.log(this.hasCBC);
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            fetch_Antigen() {
                axios.post("{{route('fetchAntigen')}}")
                    .then(response => {
                        if (response) {
                            this.hasAntigen = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            fetch_Urinalysis() {
                axios.post("{{route('fetchUrinalysis')}}")
                    .then(response => {
                        if (response) {
                            this.hasUrinalysis = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Xray() {
                axios.post("{{route('fetchXray')}}")
                    .then(response => {
                        if (response) {
                            this.hasXray = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Fecalysis() {
                axios.post("{{route('fetchFecalysis')}}")
                    .then(response => {
                        if (response) {
                            this.hasFecalysis = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Vaccine() {
                axios.post("{{route('fetchVaccine')}}")
                    .then(response => {
                        if (response) {
                            this.hasVaccine = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
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
                                        const age = localStorage.getItem("age");
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
                                        updateData.append("guardianFname", this.updateStudent.guardianFname)
                                        updateData.append("guardianMname", this.updateStudent.guardianMname)
                                        updateData.append("guardianLname", this.updateStudent.guardianLname)
                                        updateData.append("guardianPhone_number", this.updateStudent.guardianPhone_number)
                                        updateData.append("age", age)
                                        updateData.append("citizen", this.updateStudent.citizen)
                                        updateData.append("civil", this.updateStudent.civil)
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
            back() {
                if (this.active == 1) {
                    this.$confirm('There are unsaved changes. Continue?', {
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    })
                    .then(() => {
                        this.active--
                        localStorage.removeItem("active")
                        localStorage.removeItem("isCBC")
                        localStorage.removeItem("isUrinalysis")
                        localStorage.removeItem("isFecalysis")
                        localStorage.removeItem("isXray")
                        localStorage.removeItem("isAntigen")
                        localStorage.removeItem("isVaccine")
                    })
                    .catch(() => {});
                }

            },
            next() {
                if (this.isCBC) {
                    localStorage.setItem("isCBC", this.isCBC)
                } else if (this.isUrinalysis) {
                    localStorage.setItem("isUrinalysis", this.isUrinalysis)
                } else if (this.isFecalysis) {
                    localStorage.setItem("isFecalysis", this.isFecalysis)
                } else if (this.isXray) {
                    localStorage.setItem("isXray", this.isXray)
                } else if (this.isAntigen) {
                    localStorage.setItem("isAntigen", this.isAntigen)
                } else if (this.isVaccine) {
                    localStorage.setItem("isVaccine", this.isVaccine)
                }

                if (this.isCBC || this.isUrinalysis || this.isFecalysis || this.isXray || this.isAntigen || this.isVaccine) {
                    this.active++;
                    localStorage.setItem("active", this.active)
                } else {
                    this.$message.error("Please select medical results!");
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
            fileUpload(event) {
                const files = Array.from(event.target.files);
                const allowedTypes = ["image/jpeg"];
                const maxSize = 2000000; // 2MB

                // Clear previous file selection and error message
                this.fileImg = null;
                this.error = false;

                const invalidFiles = [];
                const validFiles = [];

                files.forEach((file) => {
                    // Check file type
                    if (!allowedTypes.includes(file.type)) {
                    invalidFiles.push(file);
                    return;
                    }

                    // Check file size
                    if (file.size > maxSize) {
                    invalidFiles.push(file);
                    return;
                    }

                    validFiles.push(file);
                });

                if (invalidFiles.length > 0) {
                    invalidFiles.forEach((file) => {
                    this.$message.error(
                        file.name +
                        " is invalid. Please make sure it is a JPG image and does not exceed 2MB."
                    );
                    });
                    this.error = true;
                    this.$refs.file.value = null;
                    return;
                }

                this.filesToUpload = validFiles;
                this.previewFiles(validFiles);
            },

            submitCbc(){
                if (this.$refs.file.files.length === 0) {
                    this.$message.error("Insert Result image first!");
                    this.error = true;
                }else{
                this.loadButton = true;
                const student_id = localStorage.getItem("student_id");
                var newData = new FormData()
                newData.append("student_id", student_id)
                newData.append("med_status", this.med_Status)
                newData.append("file", this.fileImg)
                axios.post("{{route('storeCbc')}}", newData)
                    .then(res => {
                        if (res) {
                            setTimeout(() => {
                                this.getData();
                                this.loadButton = false;
                                this.fileImg = null;
                                this.$message({
                                    message: 'Results has been uploaded successfully!',
                                    type: 'success'
                                });
                                localStorage.removeItem("active")
                                localStorage.removeItem("student_id")
                                localStorage.removeItem("isCBC")
                                localStorage.removeItem("isUrinalysis")
                                localStorage.removeItem("isFecalysis")
                                localStorage.removeItem("isXray")
                                localStorage.removeItem("isAntigen")
                                localStorage.removeItem("isVaccine")
                                this.resultDialog = false;
                                window.location.reload(true);
                            }, 500)
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
                }
            },
            submitUrinalysis() {
            if (this.fileList.length === 0) {
                this.$message.error("Insert Result image first!");
                this.error = true;
            } else {
                this.loadButton = true;
                const student_id = localStorage.getItem("student_id");
                const promises = [];

                for (let i = 0; i < this.fileList.length; i++) {
                const file = this.fileList[i];
                const newData = new FormData();
                newData.append("student_id", student_id);
                newData.append("med_status", this.med_Status);
                newData.append("file", file);

                promises.push(
                    axios.post("{{route('storeCbc')}}", newData)
                    .then(res => {
                        // handle success
                    })
                    .catch(error => {
                        // handle error
                    })
                );
                }

                Promise.all(promises)
                .then(() => {
                    setTimeout(() => {
                    // handle overall success
                    }, 500);
                })
                .catch(error => {
                    console.error(error.response.data);
                });
            }
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
                    .catch(error => {
                        console.error(error.response.data);
                    });
            }
        },
    });
    function printAndRemoveButtons(button) {
        window.print();
        const cancelButton = button.previousElementSibling;
        cancelButton.parentNode.removeChild(cancelButton);
        button.parentNode.removeChild(button);
        }
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