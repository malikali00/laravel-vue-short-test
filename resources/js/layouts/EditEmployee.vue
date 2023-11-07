<template>

    <div class="wrapper">
        <Sidebar />
        <Header />

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Employee</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Employee</h3>
                        </div>
                        <!-- Loading spinner -->
                        <div v-if="loading" class="loading-spinner"></div>
                        <div v-if="success" class="success-message">Form submitted successfully!</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="firstName">Fist Name</label>
                                <input type="text" class="form-control" id="firstName" placeholder="First Name" v-model="firstName">
                                <span v-if="submitted && !firstName" class="error">First Name is required</span>
                            </div>

                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" placeholder="Last Name" v-model="lastName">
                                <span v-if="submitted && !lastName" class="error">Last Name is required</span>
                            </div>

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" v-model="email">
                                <span v-if="submitted && !email" class="error">Email is required</span>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" placeholder="Enter Phone" v-model="phone">
                                <span v-if="submitted && !phone" class="error">Phone is required</span>
                            </div>

                            <div class="form-group">
                                <label>Company</label>
                                <select class="form-control" v-model="selectedCompany">
                                    <option value="">Select Company</option>
                                    <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}</option>
                                </select>
                                <span v-if="submitted && !selectedCompany" class="error">Company is required</span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" @click="submitForm">Submit</button>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>

</template>


<script>
import axios from 'axios'; // Import Axios

export default {
    data() {
        return {
            // Form fields
            employeeId: null,
            firstName: '',
            lastName: '',
            email: '',
            phone: '',
            selectedCompany: '',
            companies: [], // List of companies for the dropdown
            loading: false,
            success: false,
            submitted: false,
        };
    },
    created() {
        this.fetchCompanies();
        // Fetch employee data from the API when the component is created
        this.fetchEmployeeData();
    },
    methods: {
        fetchCompanies() {
            axios.get('/api/company') // Replace with your actual API endpoint
                .then(response => {
                    this.companies = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching companies:', error);
                });
        },
        fetchEmployeeData() {
            // Get employee's ID
            this.employeeId = this.$route.params.id;

            axios.get(`/api/employee/${this.employeeId}`)
                .then(response => {
                    const employeeData = response.data.data;
                    // Set form fields with employee data
                    this.firstName = employeeData.first_name;
                    this.lastName = employeeData.last_name;
                    this.email = employeeData.email;
                    this.phone = employeeData.phone;
                    this.selectedCompany = employeeData.company_id; // Assuming the company ID is provided
                })
                .catch(error => {
                    console.error(error);
                });
        },
        submitForm() {
            // Handle form submission, send the updated data to the API
            this.submitted = true;
            if (this.validateForm()) {
                // Prepare the data to send to the API, and make a PUT request
                const employeeData = {
                    first_name: this.firstName,
                    last_name: this.lastName,
                    email: this.email,
                    phone: this.phone,
                    company_id: this.selectedCompany,
                };

                axios.put(`/api/employee/${this.employeeId}`, employeeData) // Replace with the actual employee ID
                    .then(response => {
                        this.success = true; // Show success message
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },

        validateForm() {
            if (!this.firstName || !this.lastName || !this.email || !this.phone || !this.selectedCompany) {
                return false; // Form is not valid
            }
            return true; // Form is valid
        },
    },
};
</script>
