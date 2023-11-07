<template>

    <div class="wrapper">
        <Sidebar />
        <Header />

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Company</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Company</h3>
                        </div>
                        <!-- Loading spinner -->
                        <div v-if="loading" class="loading-spinner"></div>
                        <div v-if="success" class="success-message">Form submitted successfully!</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Company Name" v-model="name">
                            </div>

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" v-model="email">
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo" @change="handleFileChange">
                                        <label class="custom-file-label" for="logo">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Display the current image if it exists -->
                            <div v-if="currentImage">
                                <img :src="currentImage" alt="Current Logo">
                            </div>

                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="text" class="form-control" id="website" placeholder="Enter Website" v-model="website">
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
            companyId: null,
            name: '',
            email: '',
            logo: null,
            website: '',
            loading: false,
            success: false,
            submitted: false,
        };
    },
    created() {
        // Fetch data from the API when the component is created
        this.fetchCompanyData();
    },
    methods: {
        fetchCompanyData() {
            // Make an API request to get company data using the company ID (e.g., 1)
            this.companyId = this.$route.params.id; // Replace with the actual company ID

            axios.get(`/api/company/${this.companyId}`)
                .then(response => {
                    const companyData = response.data.data;

                    // Populate the form fields with the retrieved data
                    this.name = companyData.name;
                    this.email = companyData.email;
                    // You may need to adjust this depending on the API response structure

                    // Set the current image URL (if it exists)
                    this.currentImage = companyData.logo ? `../../storage/app/${companyData.logo}` : null;

                    this.website = companyData.website;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        handleFileChange(event) {
            // Handle file input change if needed
        },
        submitForm() {
            this.loading = true;

            // Create a FormData object and append form fields to it
            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('email', this.email);
            formData.append('website', this.website);

            // Append the logo file if it's selected
            if (this.logo) {
                formData.append('logo', this.logo);
            }

            // Send a PUT request to update the company
            axios
                .put(`/api/company/${this.companyId}`, formData)
                .then(response => {
                    this.loading = false;
                    this.success = true; // Show success message or perform a redirect
                })
                .catch(error => {
                    this.loading = false;
                    console.error(error);
                });
        },
    },
};
</script>
