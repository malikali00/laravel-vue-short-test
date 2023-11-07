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
                        <div class="col-sm-6">
                            <router-link :to="'/employee/add'" class="btn btn-primary" style="float:right;">
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
                            <h3 class="card-title">Employee List</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th style="width: 40px">Label</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="(employee, index) in employees" :key="employee.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ employee.first_name }} {{ employee.last_name }}</td>
                                        <td>{{ employee.email }}</td>
                                        <td>{{ employee.phone }}</td>
                                        <td>
                                            <router-link :to="'/employee/' + employee.id+ '/edit'" style="margin-right: 5px;">
                                                <i class="nav-icon fas fa-pencil-alt"></i>
                                            </router-link>
                                            <a href="#" @click="deleteEmployee(employee.id)">
                                                <i class="nav-icon fas fa-trash-alt" style="color: red;"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Display a message if no records are found -->
                                    <tr v-if="employees.length === 0">
                                        <td colspan="5" class="text-center">No employees found.</td>
                                    </tr>

                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <nav v-if="pagination">
                                <ul class="pagination justify-content-center">

                                    <li v-for="(link, index) in pagination.links" :key="index" class="page-item" :class="{ active: link.active }">
                                        <a class="page-link" @click="fetchEmployees(link.url)" v-html="link.label"></a>
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
            employees: [],
            pagination: null,
        };
    },
    created() {
        this.fetchEmployees('/api/employee');
    },
    methods: {
        fetchEmployees(url) {
            axios.get(url)
                .then(response => {
                    this.employees = response.data.data.data;
                    this.pagination = {
                        prev_page_url: response.data.data.prev_page_url,
                        next_page_url: response.data.data.next_page_url,
                        links: response.data.data.links,
                    };
                })
                .catch(error => {
                    console.error('Error fetching employees:', error);
                });
        },
        deleteEmployee(employeeId) {
            // Implement the delete logic here, using employeeId
            // You can make an API request to delete the employee
            if (confirm('Are you sure you want to delete this employee?')) {
                axios.delete(`/api/employee/${employeeId}`)
                    .then(response => {
                        // Remove the deleted employee from the employees array
                        this.employees = this.employees.filter(employee => employee.id !== employeeId);
                    })
                    .catch(error => {
                        console.error('Error deleting employee:', error);
                    });
            }
        },
    },
};
</script>
