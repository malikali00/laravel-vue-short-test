<!-- resources/js/components/Login.vue -->

<template>
    <div class="login-form">
        <h2>Login</h2>
        <form @submit.prevent="login">
            <input type="email" v-model="email" placeholder="Email" required>
            <input type="password" v-model="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

