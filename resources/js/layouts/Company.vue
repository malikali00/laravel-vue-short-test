<template>

    <div class="wrapper">
        <Sidebar />
        <Header />

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Company</h1>
                        </div>
                        <div class="col-sm-6">
                            <router-link :to="'/company/add'" class="btn btn-primary" style="float:right;">
                                +Add
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Company List</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Website</th>
                                    <th>Logo</th>
                                    <th style="width: 40px">Label</th>
                                </tr>
                                </thead>
                                <tbody>


                                <tr v-for="(company, index) in companies" :key="company.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ company.name }}</td>
                                    <td>{{ company.email }}</td>
                                    <td>{{ company.website }}</td>
                                    <td>
                                        <img :src="'/storage/app/' + company.logo" alt="Company Logo" width="50" height="50" />
                                    </td>
                                    <td>
                                        <router-link :to="'/company/' + company.id + '/edit'" style="margin-right: 5px;">
                                            <i class="nav-icon fas fa-pencil-alt"></i>
                                        </router-link>

                                        <a href="#" @click="deleteCompany(company.id)">
                                            <i class="nav-icon fas fa-trash-alt" style="color: red;"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Display a message if no records are found -->
                                <tr v-if="companies.length === 0">
                                    <td colspan="5" class="text-center">No companies found.</td>
                                </tr>

                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <nav v-if="pagination">
                                <ul class="pagination justify-content-center">

                                    <li v-for="(link, index) in pagination.links" :key="index" class="page-item" :class="{ active: link.active }">
                                        <a class="page-link" @click="fetchCompanies(link.url)" v-html="link.label"></a>
                                    </li>

                                </ul>
                            </nav>

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
            companies: [],
            pagination: null,
        };
    },
    created() {
        this.fetchCompanies('/api/company');
    },
    methods: {
        fetchCompanies(url) {
            axios.get(url)
                .then(response => {
                    this.companies = response.data.data.data;
                    console.log(response.data.data);
                    this.pagination = {
                        prev_page_url: response.data.data.prev_page_url,
                        next_page_url: response.data.data.next_page_url,
                        links: response.data.data.links,
                    };
                })
                .catch(error => {
                    console.error('Error fetching companies:', error);
                });
        },
        deleteCompany(companyId) {
            // Implement the delete logic here, using companyId
            // You can make an API request to delete the company
        },
    },
};
</script>
