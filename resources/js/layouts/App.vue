<template>

<!--
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="text-white" :to="{name : 'Login' }" v-if="$store.getters.getToken == 0">Login</router-link>
                </li>

                <li class="nav-item">
                    <router-link class="text-white ml-2" :to="{name : 'Dashboard' }" v-if="$store.getters.getToken != 0"> Dashboard</router-link>
                </li>
            </ul>
        </nav>
-->

        <router-view>

        </router-view>

</template>
