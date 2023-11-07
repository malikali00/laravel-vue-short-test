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
                            <h3 class="card-title">Add Company</h3>
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
            name: '',
            email: '',
            logo: null,
            website: '',
            loading: false,
            success: false,
        };
    },
    methods: {
        handleFileChange(event) {
            // Get the selected file from the input element
            const file = event.target.files[0];
            this.logo = file; // Store the selected file in your data

            // You can also display the file name in the custom file label
            const inputLabel = event.target.nextElementSibling; // Get the label element
            inputLabel.innerText = file.name; // Update the label with the file name
        },

        submitForm() {
            // Show loading spinner
            this.loading = true;

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('email', this.email);
            formData.append('logo', this.logo); // Assuming you have a file input
            formData.append('website', this.website);

            // Make an HTTP POST request to the API endpoint
            axios.post('/api/company', formData)
                .then(response => {
                    // Hide loading spinner
                    this.loading = false;
                    this.success = true; // Show success message
                })
                .catch(error => {
                    // Handle errors here
                    console.error(error);
                    this.loading = false;
                });
        }
    },
};
</script>
