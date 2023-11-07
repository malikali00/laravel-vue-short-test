<template>

    <div class="wrapper">
        <Sidebar />
        <Header />

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Employee</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Employee</h3>
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
import axios from 'axios';

export default {
    data() {
        return {
            companies: [], // Store the list of companies
            selectedCompany: '', // Store the selected company's ID
            firstName: '',
            lastName: '',
            email: '',
            phone: '',
            submitted: false, // Track if the form has been submitted
            loading: false, // Track loading state
            success: false, // Track success state
        };
    },
    created() {
        this.fetchCompanies(); // Fetch the list of companies when the component is created
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

        submitForm() {
            this.submitted = true; // Mark the form as submitted
            if (this.validateForm()) {
                this.loading = true; // Show loading message
                // Prepare the data to be sent to the API
                const employeeData = {
                    first_name: this.firstName,
                    last_name: this.lastName,
                    email: this.email,
                    phone: this.phone,
                    company_id: this.selectedCompany,
                };

                // Make an API request to create a new employee
                axios.post('/api/employee', employeeData)
                    .then(response => {
                        // Handle the response or redirect the user as needed
                        console.log('Employee created:', response.data);
                        this.success = true; // Show success message
                        this.loading = false; // Hide loading message
                        this.resetForm();
                    })
                    .catch(error => {
                        this.loading = false; // Hide loading message
                        console.error('Error creating employee:', error);
                    });
            }
        },

        validateForm() {
            if (!this.firstName || !this.lastName || !this.email || !this.phone || !this.selectedCompany) {
                return false; // Form is not valid
            }
            return true; // Form is valid
        },

        resetForm() {
            this.firstName = '';
            this.lastName = '';
            this.email = '';
            this.phone = '';
            this.selectedCompany = '';
            this.submitted = false;
            this.loading = false;
            this.success = false;
        },
    },
};
</script>

